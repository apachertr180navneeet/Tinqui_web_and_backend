import { PsObject } from "@templateCore/object/core/PsObject";

export default class TrackRefund extends PsObject<TrackRefund> {
    id: String = "";
    bid_id: string = "";
    refund_id: String = "";
    refund_status: String = "";
    update_date: String = "";
    created_at: String = "";
    updated_at: String = "";

    init(
        id: String,
        bid_id: string,
        refund_id: String,
        refund_status: String,
        update_date: String,
        created_at: String,
        updated_at: String
    ) {
        this.id = id;
        this.bid_id = bid_id;
        this.refund_id = refund_id;
        this.refund_status = refund_status;
        this.update_date = update_date;
        this.created_at = created_at;
        this.updated_at = updated_at;

        return this;
    }

    toMap(object: TrackRefund): any {
        const map = {};
        map["id"] = object.id;
        map["bid_id"] = object.bid_id;
        map["refund_id"] = object.refund_id;
        map["refund_status"] = object.refund_status;
        map["update_date"] = object.update_date;
        map["created_at"] = object.created_at;
        map["updated_at"] = object.updated_at;

        return map;
    }

    toMapList(objectList: TrackRefund[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new TrackRefund().init(
            obj.id,
            obj.bid_id,
            obj.refund_id,
            obj.refund_status,
            obj.update_date,
            obj.created_at,
            obj.updated_at
        );
    }

    fromMapList(objList: any[]): TrackRefund[] {
        const list: TrackRefund[] = [];
        for (const obj of objList as Array<TrackRefund>) {
            if (obj != null) {
                list.push(this.fromMap(obj));
            }
        }

        return list;
    }
}
