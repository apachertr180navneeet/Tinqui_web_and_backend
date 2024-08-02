import PsConst from "../constant/ps_constants";

export default class AuctionItemParameterHolder {

    orderType: string = '';
    paidStatus: string = '';
    status: string = '';
    auctionItem: string = '';

    constructor() {

        this.orderType = PsConst.FILTERING__DESC;
        this.paidStatus = '';
        this.status = '1';
        this.auctionItem = '1';

    }


    AuctionItemParameterHolder() {
        this.paidStatus = "normal_ads_only";
        this.orderType = "desc";
        this.status = '1';
        this.auctionItem = '1';
        return this;
    }

    toMap(): {} {
        const map = {};
        map['ad_post_type'] = this.paidStatus;
        map['order_type'] = this.orderType;
        map['status'] = this.status;
        map['auctionItem'] = this.auctionItem;

        return map;
    }

}
