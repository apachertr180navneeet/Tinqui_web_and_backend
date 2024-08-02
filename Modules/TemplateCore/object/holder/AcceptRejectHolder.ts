export default class AcceptRejectHolder {
    recharge_timestamp: string = "";
    bid_details_id: string = "";

    AcceptRejectHolder() {
        this.recharge_timestamp = "";
        this.bid_details_id = "";
    }

    toMap(): {} {
        const map = {};
        map["recharge_timestamp"] = this.recharge_timestamp;
        map["bid_details_id"] = this.bid_details_id;
        return map;
    }
}
