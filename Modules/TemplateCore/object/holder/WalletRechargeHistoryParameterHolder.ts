export default class WalletRechargeHistoryParameterHolder {
    amount: string = "";
    paymentMethod: string = "";
    paymentMethodNounce: string = "";
    rechargeTimeStamp: string = "";
    razorId: string = "";
    isPaystack: string = "";

    WalletRechargeHistoryParameterHolder() {
        this.amount = "";
        this.paymentMethod = "";
        this.paymentMethodNounce = "";
        this.rechargeTimeStamp = "";
        this.razorId = "";
        this.isPaystack = "";
    }

    toMap(): {} {
        const map = {};
        map["amount"] = this.amount;
        map["payment_method"] = this.paymentMethod;
        map["payment_method_nonce"] = this.paymentMethodNounce;
        map["recharge_timestamp"] = this.rechargeTimeStamp;
        map["razor_id"] = this.razorId;
        map["is_paystack"] = this.isPaystack;

        return map;
    }
}
