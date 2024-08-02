export default class getBidDetailsParameterHolder {
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
        map["buyer_id"] = this.buyerId;
        map["seller_id"] = this.sellerId;

        return map;
    }
}
