import { PsObject } from "@templateCore/object/core/PsObject";

export default class HistoryUserData extends PsObject<HistoryUserData> {



    user_name: string = "";
    user_email: string = "";
    user_phone: string | null = "";


    init(
        user_name: string,
        user_email: string,
        user_phone: string | null,

    ) {
        this.user_name = user_name;
        this.user_email = user_email;
        this.user_phone = user_phone;
        return this;

    }

    toMap(object: HistoryUserData): any {
        const map = {};
        map['user_name'] = object.user_name;
        map['user_email'] = object.user_email;
        map['user_phone'] = object.user_phone;

        return map;
    }

    toMapList(objectList: HistoryUserData[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new HistoryUserData().init(
            obj.user_name,
            obj.user_email,
            obj.user_phone
        );
    }

    fromMapList(objList: any[]): HistoryUserData[] {
        const list: HistoryUserData[] = [];
        for (const obj of objList as Array<HistoryUserData>) {
            if (obj != null) {
                list.push(this.fromMap(obj));
            }
        }

        return list;
    }
}
