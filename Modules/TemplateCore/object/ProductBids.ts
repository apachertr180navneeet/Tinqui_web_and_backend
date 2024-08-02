import { PsObject } from "@templateCore/object/core/PsObject";
import ProductAllBids from "./ProductAllBids";
import DefaultPhoto from "./DefaultPhoto";
import HighestBid from "./HighestBid";

export default class ProductBids extends PsObject<ProductBids> {

    total_bids: string = '';
    highest_bid: HighestBid | null = new HighestBid();
    all_bids: ProductAllBids[] = [new ProductAllBids()];
    product_id: string = '';
    product_title: string = '';
    product_image: DefaultPhoto[] = [new DefaultPhoto()];

    init(
        total_bids: string,
        highest_bid: HighestBid | null,
        all_bids: ProductAllBids[],
        product_id: string,
        product_title: string,
        product_image: DefaultPhoto[],

    ) {
        this.total_bids = total_bids;
        this.highest_bid = highest_bid;
        this.all_bids = all_bids;
        this.product_id = product_id;
        this.product_title = product_title;
        this.product_image = product_image;

        return this;

    }

    toMap(object: ProductBids): any {
        const map = {};
        map['total_bids'] = object.total_bids;
        map['highest_bid'] = object.highest_bid !== null ? new HighestBid().toMap(object.highest_bid) : null;
        map['all_bids'] = new ProductAllBids().toMapList(object.all_bids);
        map['product_id'] = object.product_id;
        map['product_title'] = object.product_title;
        map['product_image'] = new DefaultPhoto().toMapList(object.product_image)

        return map;
    }

    toMapList(objectList: ProductBids[]): any[] {
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
        return new ProductBids().init(
            obj.total_bids,
            new HighestBid().fromMap(obj.highest_bid) || null,
            new ProductAllBids().fromMapList(obj.all_bids) || [],
            obj.product_id,
            obj.product_title,
            new DefaultPhoto().fromMapList(obj.product_image)
        );
    }

    fromMapList(objList: any[]): ProductBids[] {
        const list: ProductBids[] = [];
        for (const obj of objList as Array<ProductBids>) {
            if (obj != null) {
                list.push(this.fromMap(obj));
            }
        }

        return list;
    }
}
