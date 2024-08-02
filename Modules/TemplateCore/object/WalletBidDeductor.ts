import { PsObject } from "./core/PsObject";
import Product from "./Product";

export default class WalletBidDeductor extends PsObject<WalletBidDeductor> {
    login_user_id: string = "";
    recharge_timestamp: string = "";
    seller_user_id: string = "";
    bid_price: string = "";
    product_price: string = "";
    product_id: string = "";
    product_title: string = "";
    createdAt: string = "";
    updatedAt: string = "";
    init(
        login_user_id: string,
        recharge_timestamp: string,
        seller_user_id: string,
        bid_price: string,
        product_price: string,
        product_id: string,
        product_title: string,
        createdAt: string,
        updatedAt: string
    ) {
        this.login_user_id = login_user_id;
        this.recharge_timestamp = recharge_timestamp;
        this.seller_user_id = seller_user_id;
        this.bid_price = bid_price;
        this.product_price = product_price;
        this.product_id = product_id;
        this.product_title = product_title;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;

        return this;
    }

    getPrimaryKey(): string {
        return this.login_user_id;
    }

    fromMap(obj: any) {
        return new WalletBidDeductor().init(
            obj.login_user_id,
            obj.recharge_timestamp,
            obj.seller_user_id,
            obj.bid_price,
            obj.product_price,
            obj.product_id,
            obj.product_title,
            obj.createdAt,
            obj.updatedAt
        );
    }

    fromMapList(objList: any[]): WalletBidDeductor[] {
        const itemPaidHistoryList: WalletBidDeductor[] = [];
        for (const obj in objList) {
            if (obj != null) {
                itemPaidHistoryList.push(this.fromMap(obj));
            }
        }

        return itemPaidHistoryList;
    }

    toMap(object: WalletBidDeductor): any {
        const map = {};
        map["login_user_id"] = object.login_user_id;
        map["recharge_timestamp"] = object.recharge_timestamp;
        map["seller_user_id"] = object.seller_user_id;
        map["bid_price"] = object.bid_price;
        map["product_price"] = object.product_price;
        map["product_id"] = object.product_id;
        map["product_title"] = object.product_title;
        map["created_at"] = object.createdAt;
        map["updated_at"] = object.updatedAt;

        return map;
    }

    toMapList(objectList: WalletBidDeductor[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }
}
