import { PsObject } from "./core/PsObject";

export default class DisputedBidHolder extends PsObject<DisputedBidHolder> {
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
    bid_created_at: string = "";
    disputed_bid: string = "";
    dispute_type: string = "";
    dispute_reason: string | null = "";
    dispute_status: string = "";
    dispute_status_notes: null | string = null;
    bid_payment_status: string = "";
    update_date_time: string | null = "";
    dispute_images: {} | null = {};
    dispute_refund: string = "";
    createdAt: string = "";
    updatedAt: string = "";

    init(
        id: string,
        buyerId: string,
        sellerId: string,
        bidPrice: string,
        productPrice: string,
        productId: string,
        productTitle: string,
        bidStatus: string,
        bidCommission: string,
        amountPaid: string,
        bid_created_at: string,
        disputed_bid: string,
        dispute_type: string,
        dispute_reason: null | string,
        dispute_status: string,
        dispute_status_notes: string | null,
        bid_payment_status: string,
        update_date_time: string | null,
        dispute_images: {} | null,
        dispute_refund: string,
        createdAt: string,
        updatedAt: string
    ) {
        this.id = id;
        this.buyerId = buyerId;
        this.sellerId = sellerId;
        this.bidPrice = bidPrice;
        this.productPrice = productPrice;
        this.productId = productId;
        this.productTitle = productTitle;
        this.bidStatus = bidStatus;
        this.bidCommission = bidCommission;
        this.amountPaid = amountPaid;
        this.bid_created_at = bid_created_at;
        this.disputed_bid = disputed_bid;
        this.dispute_type = dispute_type;
        this.dispute_reason = dispute_reason;
        this.dispute_status = dispute_status;
        this.dispute_status_notes = dispute_status_notes;
        this.bid_payment_status = bid_payment_status;
        this.update_date_time = update_date_time;
        this.dispute_images = dispute_images;
        this.dispute_refund = dispute_refund;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;

        return this;
    }

    getPrimaryKey(): string {
        return this.id;
    }

    fromMap(obj: any) {
        return new DisputedBidHolder().init(
            obj.id,
            obj.buyer_id,
            obj.seller_id,
            obj.bid_price,
            obj.product_price,
            obj.product_id,
            obj.product_title,
            obj.bid_status,
            obj.bid_commission,
            obj.amount_paid,
            obj.bid_created_at,
            obj.disputed_bid,
            obj.dispute_type,
            obj.dispute_reason,
            obj.dispute_status,
            obj.dispute_status_notes,
            obj.bid_payment_status,
            obj.update_date_time,
            obj.dispute_images,
            obj.dispute_refund,
            obj.created_at,
            obj.updated_at
        );
    }

    fromMapList(objList: any[]): DisputedBidHolder[] {
        const DisputedBidHolderList: DisputedBidHolder[] = [];
        for (let index = 0; index < objList.length; index++) {
            const obj = objList[index];
            if (obj != null) {
                DisputedBidHolderList.push(this.fromMap(obj));
            }
        }

        return DisputedBidHolderList;
    }

    toMap(object: DisputedBidHolder): any {
        const map = {};
        map["id"] = object.id;
        map["buyer_id"] = object.buyerId;
        map["seller_id"] = object.sellerId;
        map["bid_price"] = object.bidPrice;
        map["product_price"] = object.productPrice;
        map["product_id"] = object.productId;
        map["product_title"] = object.productTitle;
        map["bid_status"] = object.bidStatus;
        map["bid_commission"] = object.bidCommission;
        map["amount_paid"] = object.amountPaid;
        map["bid_created_at"] = object.bid_created_at;
        map["disputed_bid"] = object.disputed_bid;
        map["dispute_type"] = object.dispute_type;
        map["dispute_reason"] = object.dispute_reason;
        map["dispute_status"] = object.dispute_status;
        map["dispute_status_notes"] = object.dispute_status_notes;
        map["bid_payment_status"] = object.bid_payment_status;
        map["update_date_time"] = object.update_date_time;
        map["dispute_images"] = object.dispute_images;
        map["dispute_refund"] = object.dispute_refund;
        map["created_at"] = object.createdAt;
        map["updated_at"] = object.updatedAt;

        return map;
    }

    toMapList(objectList: DisputedBidHolder[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }
}
