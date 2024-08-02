
import { PsObject } from "@templateCore/object/core/PsObject";


export default class AcceptReject extends PsObject<AcceptReject> {

    recharge_timestamp: string = '';
    bid_details_id: string = '';


    init(

        recharge_timestamp: string,
        bid_details_id: string 


    ) {
        this.recharge_timestamp = recharge_timestamp;
        this.bid_details_id = bid_details_id;
    

        return this;

    }

    getPrimaryKey(): string {
        return this.bid_details_id;
    }

    toMap(object: AcceptReject): any {
        const map = {};

        map['recharge_timestamp'] = object.recharge_timestamp;
        map['bid_details_id'] = object.bid_details_id;

        return map;
    }

    toMapList(objectList: AcceptReject[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new AcceptReject().init(

            obj.recharge_timestamp,
            obj.bid_details_id,
            
        );
    }

    fromMapList(objList: any[]): AcceptReject[] {
        const offerList: AcceptReject[] = [];
        for (const obj in objList) {
            if (obj != null) {
                offerList.push(this.fromMap(obj));
            }
        }

        return offerList;
    }
}
