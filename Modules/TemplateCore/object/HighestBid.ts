import { PsObject } from "@templateCore/object/core/PsObject";
import TrackData from "./TrackData";

export default class HighestBid extends PsObject<HighestBid> {
    id: String = "";
    buyer_id: String = "";
    seller_id: String = "";
    bid_price: String = "";
    product_price: String = "";
    product_id: String = "";
    product_title: String = "";
    bid_status: String = "";
    bid_commission: String = "";
    amount_paid: String = "";
    disputed_bid: String = "";
    dispute_type: String = "";
    dispute_reason: String | null = "";
    dispute_status: String = "";
    dispute_status_notes: String | null = "";
    dispute_images: String | null = "";
    dispute_refund: String = "";
    bid_payment_status: String = "";
    update_date_time: String | null = "";
    bid_created_at: String = "";
    created_at: String = "";
    updated_at: String = "";
    fullname: String = "";
    username: String = "";
    trackStatus: TrackData[] = [new TrackData()];

    init(
        id: String,
        buyer_id: String,
        seller_id: String,
        bid_price: String,
        product_price: String,
        product_id: String,
        product_title: String,
        bid_status: String,
        bid_commission: String,
        amount_paid: String,
        disputed_bid: String,
        dispute_type: String,
        dispute_reason: String | null,
        dispute_status: String,
        dispute_status_notes: String | null,
        dispute_images: String | null,
        dispute_refund: String,
        bid_payment_status: String,
        update_date_time: String | null,
        bid_created_at: String,
        created_at: String,
        updated_at: String,
        fullname: String,
        username: String,
        trackStatus: TrackData[]
    ) {
        this.id = id;
        this.buyer_id = buyer_id;
        this.seller_id = seller_id;
        this.bid_price = bid_price;
        this.product_price = product_price;
        this.product_id = product_id;
        this.product_title = product_title;
        this.bid_status = bid_status;
        this.bid_commission = bid_commission;
        this.amount_paid = amount_paid;
        this.disputed_bid = disputed_bid;
        this.dispute_type = dispute_type;
        this.dispute_reason = dispute_reason;
        this.dispute_status = dispute_status;
        this.dispute_status_notes = dispute_status_notes;
        this.dispute_images = dispute_images;
        this.dispute_refund = dispute_refund;
        this.bid_payment_status = bid_payment_status;
        this.update_date_time = update_date_time;
        this.bid_created_at = bid_created_at;
        this.created_at = created_at;
        this.updated_at = updated_at;
        this.fullname = fullname;
        this.username = username;
        this.trackStatus = trackStatus;
        return this;
    }

    toMap(object: HighestBid): any {
        const map = {};

        map["id"] = object.id;
        map["buyer_id"] = object.buyer_id;
        map["seller_id"] = object.seller_id;
        map["bid_price"] = object.bid_price;
        map["product_price"] = object.product_price;
        map["product_id"] = object.product_id;
        map["product_title"] = object.product_title;
        map["bid_status"] = object.bid_status;
        map["bid_commission"] = object.bid_commission;
        map["amount_paid"] = object.amount_paid;
        map["disputed_bid"] = object.disputed_bid;
        map["dispute_type"] = object.dispute_type;
        map["dispute_reason"] = object.dispute_reason;
        map["dispute_status"] = object.dispute_status;
        map["dispute_status_notes"] = object.dispute_status_notes;
        map["dispute_images"] = object.dispute_images;
        map["dispute_refund"] = object.dispute_refund;
        map["bid_payment_status"] = object.bid_payment_status;
        map["update_date_time"] = object.update_date_time;
        map["bid_created_at"] = object.bid_created_at;
        map["created_at"] = object.created_at;
        map["updated_at"] = object.updated_at;
        map["fullname"] = object.fullname;
        map["username"] = object.username;
        map["trackStatus"] = new TrackData().toMapList(object.trackStatus);

        return map;
    }

    toMapList(objectList: HighestBid[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new HighestBid().init(
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
            obj.disputed_bid,
            obj.dispute_type,
            obj.dispute_reason,
            obj.dispute_status,
            obj.dispute_status_notes,
            obj.dispute_images,
            obj.dispute_refund,
            obj.bid_payment_status,
            obj.update_date_time,
            obj.bid_created_at,
            obj.created_at,
            obj.updated_at,
            obj.fullname,
            obj.username,
            new TrackData().fromMapList(obj.trackStatus)
        );
    }

    fromMapList(objList: any[]): HighestBid[] {
        const list: HighestBid[] = [];
        for (const obj of objList as Array<HighestBid>) {
            if (obj != null) {
                list.push(this.fromMap(obj));
            }
        }

        return list;
    }
}
