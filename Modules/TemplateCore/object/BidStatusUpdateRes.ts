import { PsObject } from "@templateCore/object/core/PsObject";

export default class BidStatusResponse extends PsObject<BidStatusResponse> {

    status: string = "";
    message: string = "";

    init(
        status: string,
        message: string,
    ) {
        this.status = status;
        this.message = message;
    
        return this;
    }

    toMap(object: BidStatusResponse): any {
        const map = {};
        map["status"] = object.status;
        map["message"] = object.message;

        return map;
    }

    toMapList(objectList: BidStatusResponse[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new BidStatusResponse().init(
           obj.status,
           obj.message
        );
    }

    fromMapList(objList: any[]): BidStatusResponse[] {
        const list: BidStatusResponse[] = [];
        for (const obj of objList as Array<BidStatusResponse>) {
            if (obj != null) {
                list.push(this.fromMap(obj));
            }
        }

        return list;
    }
}
