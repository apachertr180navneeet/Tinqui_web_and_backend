export default class ItemEntryParameterHolder {
    catId: string = "";
    subCatId: string = "";
    phone: string = "";
    itemLocationId: string = "";
    locationTownshipId: string = "";
    description: string = "";
    preferredPayment: string = "wallet";
    isWarrantyItem: string | number = 0;
    price: string = "";
    percent: string = "";
    // discountRate : string = '' ;
    isAvailable: string = "";
    title: string = "";
    latitude: string = "";
    longitude: string = "";
    itemCurrencyId: string = "";
    // businessMode : string = '';
    // businessModeBool : Boolean = false;
    // businessModeVal : string = '';
    addedUserId: string = "";

    isSoldOut: string = "";

    id: string = "";

    status: string = "1";
    isDiscount: string = "";
    vendorName: string = "";
    vendorId: string = "";
    is_auction_item: string = "";
    auction_period: string = "";
    product_creation_date: string = "";
    productRelation: [] = [];
    imgCaption: [] = [];
    imgOrder: [] = [];

    ItemEntryParameterHolder() {
        this.catId = "";
        this.subCatId = "";
        this.phone = "";
        this.itemCurrencyId = "";
        this.isAvailable = "";
        this.itemLocationId = "";
        this.locationTownshipId = "";
        this.description = "";
        this.preferredPayment = "";
        this.isWarrantyItem = 0;
        this.price = "";
        this.percent = "";
        // this.discountRate = '';
        // this.businessMode = '';
        this.isSoldOut = "";
        this.title = "";
        this.latitude = "";
        this.longitude = "";
        this.id = "";
        this.addedUserId = "";
        this.status = "1";
        this.isDiscount = "";
        this.vendorName = "";
        this.vendorId = "";
        this.is_auction_item = "";
        this.auction_period = "";
        this.product_creation_date = "";
        this.productRelation = [];
        this.imgCaption = [];
        this.imgOrder = [];
    }

    toMap(): {} {
        const map = {};
        map["category_id"] = this.catId;
        map["subcategory_id"] = this.subCatId;
        map["phone"] = this.phone;
        map["is_available"] = this.isAvailable;
        map["currency_id"] = this.itemCurrencyId;
        map["location_city_id"] = this.itemLocationId;
        map["location_township_id"] = this.locationTownshipId;
        map["description"] = this.description;
        map["preferred_payment"] = this.preferredPayment;
        map["is_warranty_item"] = this.isWarrantyItem;
        map["original_price"] = this.price;
        map["percent"] = this.percent;
        map["is_sold_out"] = this.isSoldOut;
        map["title"] = this.title;
        map["lat"] = this.latitude;
        map["lng"] = this.longitude;
        map["is_discount"] = this.isDiscount;
        map["id"] = this.id;
        map["added_user_id"] = this.addedUserId;
        map["status"] = this.status;
        map["product_relation"] = this.productRelation;
        map["img_caption"] = this.imgCaption;
        map["img_order"] = this.imgOrder;
        map["vendor_id"] = this.vendorId;
        map["is_auction_item"] = this.is_auction_item;
        map["auction_period"] = this.auction_period;
        map["product_creation_date"] = this.product_creation_date;

        return map;
    }
}
