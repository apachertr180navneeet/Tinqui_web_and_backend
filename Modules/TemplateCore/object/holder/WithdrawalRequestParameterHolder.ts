export default class WithdrawalRequestParameterHolder {
    withdraw_amount: string = "";
    currency: string = "";
    bank_name: string = "";
    bank_code: string = "";
    branch_name: string = "";
    account_number: string = "";
    account_name: string = "";
    address: string = "";
    country: string = "";
    city: string = "";
    state: string = "";
    postal_code: string = "";
    request_date: string = "";
    timestamp: string = "";

    WithdrawalRequestParameterHolder() {
        this.withdraw_amount = "";
        this.currency = "";
        this.bank_name = "";
        this.bank_code = "";
        this.branch_name = "";
        this.account_number = "";
        this.account_name = "";
        this.address = "";
        this.country = "";
        this.state = "";
        this.city = "";
        this.postal_code = "";
        this.request_date = "";
        this.timestamp = "";
    }

    toMap(): {} {
        const map = {};
        map["withdraw_amount"] = this.withdraw_amount;
        map["currency"] = this.currency;
        map["bank_name"] = this.bank_name;
        map["bank_code"] = this.bank_code;
        map["branch_name"] = this.branch_name;
        map["account_number"] = this.account_number;
        map["account_name"] = this.account_name;
        map["address"] = this.address;
        map["state"] = this.state;
        map["city"] = this.city;
        map["postal_code"] = this.postal_code;
        map["country"] = this.country;
        map["request_date"] = this.request_date;
        map["timestamp"] = this.timestamp;

        return map;
    }
}
