export default class DisputeHistoryParameterHolder {
    id: string = "";
    buyerId: string = "";
    sellerId: string = "";
    bidPrice: string = "";
    productPrice: string = "";
    productId: string = "";
    productTitle: string = "";
    bidStatus: string = "";
    bidCommission: string = "";
    amountPaid: string = "";
    disputedBid: string = "";
    disputeType: string = "";
    disputeReason: string = "";
    disputeStatus: string = "";
    disputeStatusNotes: string = "";
    disputeImages: string = "";
    dispute_refund: string = "";
    updatedateTime: string = "";
    buyerName: string = "";
    sellerName: string = "";
    buyerEmail: string = "";
    sellerEmail: string = "";
    createdAt: string = "";
    updatedAt: string = "";

    DisputeHistoryParameterHolder() {
        this.id = "";
        this.buyerId = "";
        this.sellerId = "";
        this.bidPrice = "";
        this.productPrice = "";
        this.productId = "";
        this.productTitle = "";
        this.bidStatus = "";
        this.bidCommission = "";
        this.amountPaid = "";
        this.disputedBid = "";
        this.disputeType = "";
        this.disputeReason = "";
        this.disputeStatus = "";
        this.disputeStatusNotes = "";
        this.disputeImages = "";
        this.dispute_refund = "";
        this.updatedateTime = "";
        this.buyerName = "";
        this.sellerName = "";
        this.buyerEmail = "";
        this.sellerEmail = "";
        this.createdAt = "";
        this.updatedAt = "";
    }

    toMap(): {} {
        const map = {};
        map["id"] = this.id;
        map["buyer_id"] = this.buyerId;
        map["seller_id"] = this.sellerId;
        map["bid_price"] = this.bidPrice;
        map["product_price"] = this.productPrice;
        map["product_id"] = this.productId;
        map["product_title"] = this.productTitle;
        map["bid_status"] = this.bidStatus;
        map["bid_status"] = this.bidStatus;
        map["bid_commission"] = this.bidCommission;
        map["disputed_bid"] = this.disputedBid;
        map["dispute_type"] = this.disputeType;
        map["dispute_reason"] = this.disputeReason;
        map["dispute_status"] = this.disputeStatus;
        map["dispute_status_notes"] = this.disputeStatusNotes;
        map["dispute_images"] = this.disputeImages;
        map["dispute_refund"] = this.dispute_refund;
        map["update_date_time"] = this.updatedateTime;
        map["buyer_name"] = this.buyerName;
        map["buyer_email"] = this.buyerEmail;
        map["seller_name"] = this.sellerName;
        map["seller_email"] = this.sellerEmail;
        map["created_at"] = this.createdAt;
        map["updated_at"] = this.updatedAt;

        return map;
    }
}
