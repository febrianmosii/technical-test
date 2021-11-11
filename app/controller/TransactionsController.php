<?php

/**
 * Transaction Controller Class
 *
 * @package     REST
 * @author      Mohamad Febrian Mosii <febrianaries@gmail.com>
 * @link        https://febrian.info
 */

class TransactionsController
{
    /**
     * Retrieving all transactions or single transaction
     *
     * @return void
     */
    public static function listTransactions()
    {
        $get = $_GET;

        // Form validation
        $isValidateForm = RestHelper::empty_form_validations([
            'merchant_id'
        ]);

        // If valid validation
        if ($isValidateForm['status'] OR ! empty($get['references_id'])) {
            $merchantId   = '';
            $referencesId = ! empty($get['references_id']) ? $get['references_id'] : '';

            // If references id is null, then validate merchant to ensure merchant id is exists 
            if ( ! empty($get['merchant_id'])) {
                $merchantId = filter_var($get['merchant_id'], FILTER_VALIDATE_INT);

                // Check is merchant exists?
                self::validateMerchant($merchantId);
            }
    
            // Getting list data
            $data = TransactionModel::getTransactions($merchantId, $referencesId);

            if ( ! $data) {
                RestHelper::set_response(404, "Data is empty");
            } else {
                // Couples of data response
                if ( ! $referencesId) {
                    $return = [];
    
                    foreach ($data as $key => $value) {
                        $return[$key]['references_id'] = sha1($value->id);    
                        $return[$key]['invoice_id']    = $value->invoice_id;    
                        $return[$key]['status']        = StatusModel::getStatusNameById($value->ref_status_id);    
                    }
                    
                } else {
                    // Single data response
                    $return = [
                        'references_id' => sha1($data->id),
                        'invoice_id'    => $data->invoice_id,
                        'status'        => StatusModel::getStatusNameById($data->ref_status_id)
                    ];
                }
            }

            
            RestHelper::set_response(200, "Success to retrieve data", $return);
        } else {
            RestHelper::set_response(422, "Validation error", $isValidateForm['message']);
        }
    }

    /**
     * Create new transaction into database
     *
     * @return void
     */
    public static function createTransaction()
    {
        $post = $_POST;

        // Form validation
        $isValidateForm = RestHelper::empty_form_validations([
            'invoice_id',
            'payment_type',
            'customer_name',
            'merchant_id',
            'array_items'
        ]);

        // If valid validation
        if ($isValidateForm['status']) {
            self::validateForm($post);
            
            $items        = $post['items'];
            $paymentType  = $post['payment_type'];

            unset($post['items'], $post['payment_type']);

            try {
                $numberVa = null;

                if ($paymentType == 'virtual_account') {
                    // Generate VA.
                    // Using `do-while` to prevent duplication in database to ensure the VA is absolutely unique. 
                    // Mechanism: If the same VA found in database, then regenerate VA Number.
                    do {
                        $numberVa = self::generateVirtualAccount();
                    } while (TransactionModel::findByVA($numberVa));

                    $post['number_va'] = $numberVa;
                }

                $post['ref_payment_type_id'] = PaymentTypeModel::getIdByCode($paymentType);

                // Insert transaction master
                $transactionId = TransactionModel::create($post);

                foreach ($items as $key => $value) {
                    $items[$key]['transaction_id'] = $transactionId;
                }

                // Insert detail item
                TransactionDetailModel::createBatch($items);
                
                RestHelper::set_response(200, "Transaction created successfully", [
                    "references_id" => sha1($transactionId),
                    "number_va" => $numberVa,
                    "status" => "Pending"
                ]);
            } catch (\Throwable $th) {
                RestHelper::set_response(500, "Internal server error");
            }
        } else {
            RestHelper::set_response(422, "Validation error", $isValidateForm['message']);
        }
    }

    /**
     * Update transaction's status
     * @param  string $args CLI Parameters
     * @return void
     */
    public static function updateTransaction($args)
    {
        // Empty form validations
        $referencesId = ( ! empty($args[1])) ? strtolower($args[1]) : null;
        $statusCode   = ( ! empty($args[2])) ? strtolower($args[2]) : null;

        if ( ! $referencesId OR !  $statusCode) {
            echo "Parameter is incomplete.";
            die();
        }

        $enum_statuses = [
            'pending', 
            'paid', 
            'failed'
        ];

        if ( ! in_array($statusCode, $enum_statuses)) {
            echo "Status code is not valid";
            die();
        }

        try {
            // Check transaction
            $transaction = TransactionModel::findByReferencesId($referencesId);
    
            if ( ! $transaction) {
                echo "References id not found";
            } else {
                TransactionModel::updateTransaction($referencesId, $statusCode);
                echo "Transaction status has been updated to '".ucwords($statusCode)."' for ".$referencesId;
            }
        } catch (\Throwable $th) {
            echo "Internal server error";
        }
    }

    /**
     * Form validations section
     *
     * @param  string $post data to be validated
     * @return void
     */
    private static function validateForm($post) {
        $merchantId = filter_var($post['merchant_id'], FILTER_VALIDATE_INT);

        // Validate length to prevent SQL Errors while inserting
        if ( ! RestHelper::length_validations($post['invoice_id'], 25)) {
            RestHelper::set_response(422, "Sorry, maximum length for Invoice ID is 25");
        } 
        if ( ! RestHelper::length_validations($post['customer_name'], 255)) {
            RestHelper::set_response(422, "Sorry, maximum length for Invoice ID is 255");
        } 

        // Check enumartion for payment type
        if ( ! in_array($post['payment_type'], ['credit_card', 'virtual_account'])) {
            RestHelper::set_response(422, "Sorry, payment type is not valid");
        }

        // Check is merchant exists?
        self::validateMerchant($merchantId);
        
        // Check is invoice already exists?
        if (TransactionModel::findByInvoiceId($post['invoice_id'])) {
            RestHelper::set_response(422, "Invoice ID is already exists!");
        }

        foreach ($post['items'] as $key => $value) {
            // Sanitize integer value
            $amount = filter_var($value['amount'], FILTER_VALIDATE_INT);

            // Validate item name
            if (empty($value['item_name'])) {
                RestHelper::set_response(422, "Item name is not valid for key [$key]");
            }

            if ( ! RestHelper::length_validations($value['item_name'], 255)) {
                RestHelper::set_response(422, "Sorry, maximum length for item name is 255");
            }

            // Validate amount payload, must be valid integer and must be larger than 0
            if ($amount < 0 OR $amount === 0 OR empty($amount)) {
                RestHelper::set_response(422, "Amount is not valid for key [$key]");
            }
        }
    }

    /**
     * Validate if merchant is valid
     *
     * @param  int  $merchantId  Mechant ID to be validated, merchant id can be seen on ref_merchants table 
     * @return void
     */
    private static function validateMerchant($merchantId) {
        if ( ! MerchantModel::findById($merchantId)) {
            RestHelper::set_response(422, "Merchant not found");
        }
    }

    /**
     * Validate if merchant is valid
     *
     *
     * @param  string $prefix Virtual Account Prefix
     * @return string
     */
    private static function generateVirtualAccount($prefix = "100299") {
        $randomNumber = '';

        for ($i = 0; $i <= 7; $i++) 
        {
            $randomNumber .= mt_rand(0,9);
        }

        return $prefix.$randomNumber;
    }
}