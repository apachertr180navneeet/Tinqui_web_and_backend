export default class getChatBidDetailsHolder {
    itemId: string = "";
    buyerId: string = "";
    sellerId: string = "";

    AppInfoParameterHolder() {
        this.itemId = "";
        this.buyerId = "";
        this.sellerId = "";
    }

    toMap(): {} {
        const map = {};
        map["item_id"] = this.itemId;
        map["buyer_user_id"] = this.buyerId;
        map["seller_user_id"] = this.sellerId;

        return map;
    }
}
