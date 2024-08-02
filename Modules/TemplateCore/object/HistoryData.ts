import { PsObject } from "@templateCore/object/core/PsObject";
import HistoryUserData from "./HistoryUserData";
import AuctionItem from "./AuctionItem";
import TrackData from "./TrackData";

export default class HistoryData extends PsObject<HistoryData> {
    id: string = "";
    buyer_id: string = "";
    seller_id: string = "";
    bid_price: string = "";
    product_price: string = "";
    product_id: string = "";
    product_title: string = "";
    bid_status: string = "";
    bid_commission: string = "";
    amount_paid: string = "";
    disputed_bid: string = "";
    dispute_type: string = "";
    dispute_reason: string | null = "";
    dispute_status: string = "";
    dispute_status_notes: string | null = "";
    dispute_images: {} | null = {};
    dispute_refund: string = "";
    bid_payment_status: string = "";
    payment_type: string = "";
    update_date_time: string | null = "";
    bid_created_at: string = "";
    created_at: string = "";
    updated_at: string = "";
    buyerData: HistoryUserData[] = [new HistoryUserData()];
    sellerData: HistoryUserData[] = [new HistoryUserData()];
    productData: AuctionItem = new AuctionItem();
    trackStatus: TrackData[] = [new TrackData()];
    init(
        id: string,
        buyer_id: string,
        seller_id: string,
        bid_price: string,
        product_price: string,
        product_id: string,
        product_title: string,
        bid_status: string,
        bid_commission: string,
        amount_paid: string,
        disputed_bid: string,
        dispute_type: string,
        dispute_reason: string | null,
        dispute_status: string,
        dispute_status_notes: string | null,
        dispute_images: {} | null,
        dispute_refund: string,
        bid_payment_status: string,
        payment_type: string,
        update_date_time: string | null,
        bid_created_at: string,
        created_at: string,
        updated_at: string,
        buyerData: HistoryUserData[],
        sellerData: HistoryUserData[],
        productData: AuctionItem,
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
        this.payment_type = payment_type;
        this.update_date_time = update_date_time;
        this.bid_created_at = bid_created_at;
        this.created_at = created_at;
        this.updated_at = updated_at;
        this.buyerData = buyerData;
        this.sellerData = sellerData;
        this.productData = productData;
        this.trackStatus = trackStatus;
        return this;
    }

    toMap(object: HistoryData): any {
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
        map["payment_type"] = object.payment_type;
        map["update_date_time"] = object.update_date_time;
        map["bid_created_at"] = object.bid_created_at;
        map["created_at"] = object.created_at;
        map["updated_at"] = object.updated_at;
        map["buyerData"] = new HistoryUserData().toMapList(object.buyerData);
        map["sellerData"] = new HistoryUserData().toMapList(object.sellerData);
        map["productData"] = new AuctionItem().toMap(object.productData);
        map["trackStatus"] = new TrackData().toMapList(object.trackStatus);

        return map;
    }

    toMapList(objectList: HistoryData[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        // console.log("obj from map ", obj)
        return new HistoryData().init(
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
            obj.payment_type,
            obj.update_date_time,
            obj.bid_created_at,
            obj.created_at,
            obj.updated_at,
            new HistoryUserData().fromMapList(obj.buyerData),
            new HistoryUserData().fromMapList(obj.sellerData),
            new AuctionItem().fromMap(obj.productData),
            new TrackData().fromMapList(obj.trackStatus)
        );
    }

    fromMapList(objList: any[]): HistoryData[] {
        const list: HistoryData[] = [];
        for (const obj of objList as Array<HistoryData>) {
            if (obj != null) {
                list.push(this.fromMap(obj));
            }
        }

        return list;
    }
}
