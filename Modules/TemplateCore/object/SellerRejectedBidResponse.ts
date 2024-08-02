import DisputedBidHolder from "./DisputedBidsHolder";
import { PsObject } from "./core/PsObject";

export default class BidRejectResponse extends PsObject<BidRejectResponse> {
    id: string = "";
    sellerId: string = "";
    buyerId: string = "";
    bidPrice: string | number = "";
    productPrice: string | number = "";
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
    disputeImages: string[] | null = null;
    dispute_refund: String = "";
    bidPaymentStatus: string = "";
    updateDateTime: string = "";
    createdAt: string = "";
    updatedAt: string = "";

    init(
        id: string,
        sellerId: string,
        buyerId: string,
        bidPrice: string | number,
        productPrice: string | number,
        productId: string,
        productTitle: string,
        bidStatus: string,
        bidCommission: string,
        amountPaid: string,
        disputedBid: string,
        disputeType: string,
        disputeReason: string,
        disputeStatus: string,
        disputeStatusNotes: string,
        disputeImages: string[],
        dispute_refund: String,
        bidPaymentStatus: string,
        updateDateTime: string,
        createdAt: string,
        updatedAt: string
    ) {
        this.id = id;
        this.sellerId = sellerId;
        this.buyerId = buyerId;
        this.bidPrice = bidPrice;
        this.productPrice = productPrice;
        this.productId = productId;
        this.productTitle = productTitle;
        this.bidStatus = bidStatus;
        this.bidCommission = bidCommission;
        this.amountPaid = amountPaid;
        this.disputedBid = disputedBid;
        this.disputeType = disputeType;
        this.disputeReason = disputeReason;
        this.disputeStatus = disputeStatus;
        this.disputeStatusNotes = disputeStatusNotes;
        this.disputeImages = disputeImages;
        this.dispute_refund = dispute_refund;
        this.bidPaymentStatus = bidPaymentStatus;
        this.updateDateTime = updateDateTime;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;

        return this;
    }

    getPrimaryKey(): string {
        return this.id;
    }

    fromMap(obj: any) {
        return new BidRejectResponse().init(
            obj.id,
            obj.sellerId,
            obj.buyerId,
            obj.bidPrice,
            obj.productPrice,
            obj.productId,
            obj.productTitle,
            obj.bidStatus,
            obj.bidCommission,
            obj.amountPaid,
            obj.disputedBid,
            obj.disputeType,
            obj.disputeReason,
            obj.disputeStatus,
            obj.disputeStatusNotes,
            obj.disputeImages,
            obj.dispute_refund,
            obj.bidPaymentStatus,
            obj.updateDateTime,
            obj.createdAt,
            obj.updatedAt
        );
    }

    fromMapList(objList: any[]): BidRejectResponse[] {
        const BuyNowHolderList: BidRejectResponse[] = [];
        for (let index = 0; index < objList.length; index++) {
            const obj = objList[index];
            if (obj != null) {
                BuyNowHolderList.push(this.fromMap(obj));
            }
        }

        return BuyNowHolderList;
    }

    toMap(object: BidRejectResponse): any {
        const map = {};
        map["id"] = object.id;
        map["seller_id"] = object.sellerId;
        map["buyer_id"] = object.buyerId;
        map["bid_price"] = object.bidPrice;
        map["product_price"] = object.productPrice;
        map["product_id"] = object.productId;
        map["product_title"] = object.productTitle;
        map["bid_status"] = object.bidStatus;
        map["bid_commission"] = object.bidCommission;
        map["amount_paid"] = object.amountPaid;
        map["disputed_bid"] = object.disputedBid;
        map["dispute_type"] = object.disputeType;
        map["dispute_reason"] = object.disputeReason;
        map["dispute_status"] = object.disputeStatus;
        map["dispute_status_notes"] = object.disputeStatusNotes;
        map["dispute_images"] = object.disputeImages;
        map["dispute_refund"] = object.dispute_refund;
        map["bid_payment_status"] = object.bidPaymentStatus;
        map["update_date_time"] = object.updateDateTime;
        map["created_at"] = object.createdAt;
        map["updated_at"] = object.updatedAt;

        return map;
    }

    toMapList(objectList: BidRejectResponse[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }
}
