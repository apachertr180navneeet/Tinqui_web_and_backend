export default class RefundBidParameterHolder {
    bidId: string = "";
    updateDate: string = "";
    rechargeTimeStamp: string = "";

    RefundBidParameterHolder() {
        this.bidId = "";
        this.updateDate = "";
        this.rechargeTimeStamp = "";
    }

    toMap(): {} {
        const map = {};
        map["bid_id"] = this.bidId;
        map["update_date"] = this.updateDate;
        map["recharge_timestamp"] = this.rechargeTimeStamp;
        return map;
    }
}
