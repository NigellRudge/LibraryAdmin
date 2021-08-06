<?php


namespace App\services;


class MembershipFeeService
{
    /**
     *
     * This function generates the invoices for all the active members
     */
    public function generateMemberFees(){

    }

    /*
     *
     * This function generates the late Fees for all of the overdue loans
     * this function is run every day at 00:00:00
     * */
    public function generateLateFees(){

    }

    /*
     * get All the information (member , reason and payments for the selected fee)
     * */
    public function getFeeInfo(array $data){

    }

    public function settleFee($feeId, array $data){

    }

    public function getMemberFees(array $filterOptions){

    }

    public function updateFee($feeId, array $data){

    }

    public function deleteFee($feeId){

    }
}
