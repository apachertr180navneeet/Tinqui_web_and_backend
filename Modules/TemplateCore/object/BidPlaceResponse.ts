import { PsObject } from "./core/PsObject";

export default class BidPlaceResponse extends PsObject<BidPlaceResponse> {
    id: string = "";
    buyerId: string = "";
    sellerId: string = "";
    bidPrice: string = "";
    productPrice: string = "";
    productId: string = "";
    productTitle: string = "";
    bidStatus: string = "";
    amountPaid: string = "";
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
        amountPaid: string,
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
        this.amountPaid = amountPaid;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;

        return this;
    }

    getPrimaryKey(): string {
        return this.id;
    }

    fromMap(obj: any) {
        return new BidPlaceResponse().init(
            obj.id,
            obj.buyer_id,
            obj.seller_id,
            obj.bid_price,
            obj.product_price,
            obj.product_id,
            obj.product_title,
            obj.bid_status,
            obj.amount_paid,
            obj.created_at,
            obj.updated_at
        );
    }

    fromMapList(objList: any[]): BidPlaceResponse[] {
        const BidDetailsHistoryList: BidPlaceResponse[] = [];
        for (let index = 0; index < objList.length; index++) {
            const obj = objList[index];
            if (obj != null) {
                BidDetailsHistoryList.push(this.fromMap(obj));
            }
        }

        return BidDetailsHistoryList;
    }

    toMap(object: BidPlaceResponse): any {
        const map = {};
        map["id"] = object.id;
        map["buyer_id"] = object.buyerId;
        map["seller_id"] = object.sellerId;
        map["bid_price"] = object.bidPrice;
        map["product_price"] = object.productPrice;
        map["product_id"] = object.productId;
        map["product_title"] = object.productTitle;
        map["bid_status"] = object.bidStatus;
        map["bid_status"] = object.bidStatus;
        map["created_at"] = object.createdAt;
        map["updated_at"] = object.updatedAt;

        return map;
    }

    toMapList(objectList: BidPlaceResponse[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }
}
