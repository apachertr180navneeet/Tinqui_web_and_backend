export default class WalletBidDeductionHolder {
    login_user_id: string = "";
    recharge_timestamp: string = "";
    seller_user_id: string = "";
    bid_price: string = "";
    product_price: string = "";
    product_id: string = "";
    product_title: string = "";

    WalletBidDeductionHolder() {
        this.login_user_id = "";
        this.recharge_timestamp = "";
        this.seller_user_id = "";
        this.bid_price = "";
        this.product_price = "";
        this.product_id = "";
        this.product_title = "";
    }

    toMap(): {} {
        const map = {};
        map["login_user_id"] = this.login_user_id;
        map["recharge_timestamp"] = this.recharge_timestamp;
        map["seller_user_id"] = this.seller_user_id;
        map["bid_price"] = this.bid_price;
        map["product_price"] = this.product_price;
        map["product_id"] = this.product_id;
        map["product_title"] = this.product_title;

        return map;
    }
}
