export default class DisputeFormHolder {
    itemId:string = "";
    images:[] = [];
    reason:string = "";

    DisputeFormHolder() {
     this.itemId = "";
     this.images = [];
     this.reason = "";
    }

    toMap(): {} {
        const map = {};
        map["itemId"] = this.itemId;
        map["images"] = this.images;
        map["reason"] = this.reason;
        return map;
    }
}
