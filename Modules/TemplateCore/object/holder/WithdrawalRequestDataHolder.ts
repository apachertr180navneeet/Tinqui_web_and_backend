export default class WithdrawalRequestDataHolder {
    id: string = "";
    user_id: string = "";
    withdraw_amount: string = "";
    currency: string = "";
    bank_name: string = "";
    bank_code: string = "";
    branch_name: string = "";
    account_number: string = "";
    account_name: string = "";
    address: string = "";
    country: string = "";
    withdraw_status: string = "";
    request_date: string = "";
    processing_date: string = "";
    decline_reason: string = "";
    notes: string = "";
    user_email: string = "";

    WithdrawalRequestDataHolder() {
        this.id = "";
        this.user_id = "";
        this.withdraw_amount = "";
        this.currency = "";
        this.bank_name = "";
        this.bank_code = "";
        this.branch_name = "";
        this.account_number = "";
        this.account_name = "";
        this.address = "";
        this.country = "";
        this.withdraw_status = "";
        this.request_date = "";
        this.processing_date = "";
        this.decline_reason = "";
        this.notes = "";
        this.user_email = "";
    }

    toMap(): {} {
        const map = {};
        map["id"] = this.id;
        map["user_id"] = this.user_id;
        map["withdraw_amount"] = this.withdraw_amount;
        map["currency"] = this.currency;
        map["bank_name"] = this.bank_name;
        map["bank_code"] = this.bank_code;
        map["branch_name"] = this.branch_name;
        map["account_number"] = this.account_number;
        map["account_name"] = this.account_name;
        map["address"] = this.address;
        map["country"] = this.country;
        map["withdraw_status"] = this.withdraw_status;
        map["request_date"] = this.request_date;
        map["processing_date"] = this.processing_date;
        map["decline_reason"] = this.decline_reason;
        map["notes"] = this.notes;
        map["user_email"] = this.user_email;

        return map;
    }
}
