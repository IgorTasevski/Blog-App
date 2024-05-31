<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HandleDbTransactionTrait
{
    /**
     * @param callable $callback
     * @param string $errorMessage
     * @return mixed
     */
    protected function handleDbTransaction(
        callable $callback,
        string $errorMessage = "An error has occurred while executing the operation. Please try again later."
    ): mixed {
        try {
            DB::beginTransaction();

            $result = $callback();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollback();

            throw new \RuntimeException($errorMessage);
        }
    }
}
