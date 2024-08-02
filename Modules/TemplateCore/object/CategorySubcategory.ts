import DefaultIcon from "./DefaultIcon";
import { PsObject } from "@templateCore/object/core/PsObject";
import DefaultPhoto from "./DefaultPhoto";
import SubCategory from "./SubCategory";

export default class CategorySubcategory extends PsObject<CategorySubcategory> {
    catId: string = "";
    catName: string = "";
    catOrdering: string = "";
    status: string = "";
    addedDate: string = "";
    addedDateStr: string = "";
    defaultPhoto: DefaultPhoto = new DefaultPhoto();
    defaultIcon: DefaultIcon = new DefaultIcon();
    categoryTouchCount: string = "";
    subCategories: SubCategory[] = [new SubCategory()];

    init(
        catId: string,
        catName: string,
        catOrdering: string,
        status: string,
        addedDate: string,
        addedDateStr: string,
        defaultPhoto: DefaultPhoto,
        defaultIcon: DefaultIcon,
        categoryTouchCount: string,
        subCategories: SubCategory[]
    ) {
        this.catId = catId;
        this.catName = catName;
        this.catOrdering = catOrdering;
        this.status = status;
        this.addedDate = addedDate;
        this.addedDateStr = addedDateStr;
        this.defaultPhoto = defaultPhoto;
        this.defaultIcon = defaultIcon;
        this.categoryTouchCount = categoryTouchCount;
        this.subCategories = subCategories;

        return this;
    }

    getPrimaryKey(): string {
        return this.catId;
    }

    toMap(object: CategorySubcategory): any {
        const map = {};

        map["id"] = object.catId;
        map["name"] = object.catName;
        map["ordering"] = object.catOrdering;
        map["status"] = object.status;
        map["added_date"] = object.addedDate;
        map["added_date_str"] = object.addedDateStr;
        map["default_photo"] = new DefaultPhoto().toMap(object.defaultPhoto);
        map["default_icon"] = new DefaultIcon().toMap(object.defaultIcon);
        map["category_touch_count"] = object.categoryTouchCount;
        map["subcats"] = new SubCategory().toMapList(object.subCategories);

        return map;
    }

    toMapList(objectList: CategorySubcategory[]): any[] {
        const mapList: any[] = [];
        for (let i = 0; i < objectList.length; i++) {
            if (objectList[i] != null) {
                mapList.push(this.toMap(objectList[i]));
            }
        }

        return mapList;
    }

    fromMap(obj: any) {
        return new CategorySubcategory().init(
            obj.id,
            obj.name,
            obj.ordering,
            obj.status,
            obj.added_date,
            obj.added_date_str,
            new DefaultPhoto().fromMap(obj.default_photo),
            new DefaultIcon().fromMap(obj.default_icon),
            obj.category_touch_count,
            new SubCategory().fromMapList(obj.subcats)
        );
    }

    fromMapList(objList: any[]): CategorySubcategory[] {
        const category: CategorySubcategory[] = [];
        for (const obj of objList as Array<CategorySubcategory>) {
            if (obj != null) {
                category.push(this.fromMap(obj));
            }
        }

        return category;
    }
}
