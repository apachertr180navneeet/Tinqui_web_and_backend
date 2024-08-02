import { PsObject } from "@templateCore/object/core/PsObject";

export default class TrackData extends PsObject<TrackData> {

    id: String = "";
    bid_id: string = "";
    item_status: String = "";
    updated_by_id: String = "";
    updated_by: String = "";
    update_date: String = "";
    status_notes: String = "";
    created_at: String = "";
    updated_at: String = "";

    init(
        id: String,
        bid_id: string,
        item_status: String,
        updated_by_id: String,
        updated_by: String,
        update_date: String,
        status_notes: String,
        created_at: String,
        updated_at: String,
    ) {
        this.id = id;
        this.bid_id = bid_id;
        this.item_status = item_status;
        this.updated_by_id = updated_by_id;
        this.updated_by = updated_by;
        this.update_date = update_date;
        this.status_notes = status_notes;
        this.created_at = created_at;
        this.updated_at = updated_at;

        return this;

    }

    toMap(object: TrackData): any {
        const map = {};
       map["id"] = object.id;
       map["bid_id"] = object.bid_id;
       map["item_status"] = object.item_status;
       map["updated_by_id"] = object.updated_by_id;
       map["updated_by"] = object.updated_by;
       map["update_date"] = object.update_date;
       map["status_notes"] = object.status_notes;
       map["created_at"] = object.created_at;
       map["updated_at"] = object.updated_at;

        return map;
    }

    toMapList(objectList: TrackData[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new TrackData().init(
            obj.id,
            obj.bid_id,
            obj.item_status,
            obj.updated_by_id,
            obj.updated_by,
            obj.update_date,
            obj.status_notes,
            obj.created_at,
            obj.updated_at,
        );
    }

    fromMapList(objList: any[]): TrackData[] {
        const list: TrackData[] = [];
        for (const obj of objList as Array<TrackData>) {
            if (obj != null) {
                list.push(this.fromMap(obj));
            }
        }

        return list;
    }
}
