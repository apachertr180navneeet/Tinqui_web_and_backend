<template>

  <Head :title="$t('edit_profile__edit_profile')" />
  <ps-content-container>
    <template #content>
      <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
        <div class="w-full mb-6">
          <ps-breadcrumb-2 :items="breadcrumb" class="" />
        </div>

        <div class="">
          <div
            class="w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24">
            <div class="flex w-full items-center justify-center sm:items-start sm:justify-start">
              <div class="mx-2 w-48 h-44 sm:w-52 sm:h-48 rounded-full relative">
                <!-- <ps-label-title-3 class="mt-1 "> {{ $t("edit_profile__profile_photo") }} </ps-label-title-3> -->
                <div
                  class="absolute end-0 mt-18 sm:mt-20 cursor-pointer bg-feAchromatic-900 text-feAchromatic-50 p-2 rounded-full"
                  @click="onImageClick" for="upload-image1">
                  <ps-icon name="pancel_dash" w="19" h="21" viewBox="0 0 19 21" />
                </div>
                <input class="relative" type="file" size="1" max="1" accept=".jpg,.jpeg,.png"
                  @change="onImageSelected($event)" ref="image" id="upload-image1" style="display: none"
                  :ordering="1" />
                <div class="w-44 h-44 sm:w-48 sm:h-48 rounded-full overflow-hidden flex items-center justify-center">
                  <img v-if="previewImage.data == '' && profilePhoto != '' || null" alt="Placeholder" width="300px"
                    height="300px" class="w-44 h-44 sm:w-48 sm:h-48 object-cover" :src="$page.props.thumb3xUrl +
                      '/' +
                      profilePhoto
                      " @error="userStore.defaultProfileImage" />
                       <img v-else-if="previewImage.data == ''" alt="Placeholder" width="300px"
                    height="300px" class="w-44 h-44 sm:w-48 sm:h-48 object-cover" :src="userStore.defaultProfileImage
                      " @error="userStore.defaultProfileImage" />
                  <img v-else v-for="image in previewImage.data" :key="image" alt="Placeholder" width="300px"
                    height="300px" class="w-44 h-44 sm:w-48 sm:h-48 object-cover" :src="image" @click="onImageClick" />
                </div>
              </div>
            </div>
            <div class="sm:grid grid-cols-2 w-full mt-10 sm:mt-12 gap-6">
              <div class="flex flex-col w-full">
                <!-- for User Name -->
                <div class="mb-6" v-for="(
                                            coreField, index
                                        ) in customFieldStore.customField.data?.coreList.filter(
                                              (coreField) =>
                                                coreField.fieldName ===
                                                'username' &&
                                                coreField.isVisible === '1'
                                            )" :key="index">
                  <ps-label class="text-base">{{ $t(coreField.labelName) }}
                    <span v-if="(coreField.mandatory = 1)" class="text-feError-800 font-medium ms-1">*</span></ps-label>
                  <ps-input ref="userName" type="text" v-model:value="holder.userName" class="dark:bg-transparent"
                    :placeholder="$t(coreField.placeholder)" @keypress="userNameStatus = false" />
                  <ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500" v-if="userNameStatus">
                    {{
                      $t(
                        "item_entry__username_required_error"
                      )
                    }}
                  </ps-label>
                </div>

                <!-- end user name -->
                <!-- for email -->
                <div class="mb-6" v-for="(
                                            coreField, index
                                        ) in customFieldStore.customField.data?.coreList.filter(
                                              (coreField) =>
                                                coreField.fieldName === 'email' &&
                                                coreField.isVisible === '1'
                                            )" :key="index">
                  <ps-label class="text-base">{{ $t(coreField.labelName) }}
                    <span v-if="(coreField.mandatory = 1)" class="text-feError-800 font-medium ms-1">*</span></ps-label>
                  <ps-input readonly ref="email" type="email" v-model:value="holder.userEmail"
                    class="dark:bg-transparent" :placeholder="$t(coreField.placeholder)"
                    @keypress="emailStatus = false" />
                  <ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500" v-if="emailStatus">
                    {{
                      $t(
                        "item_entry__email_required_error"
                      )
                    }}
                  </ps-label>
                </div>

                <!-- for phone -->
                <div class="mb-6" v-for="(
                                            coreField, index
                                        ) in customFieldStore.customField.data?.coreList.filter(
                                              (coreField) =>
                                                coreField.fieldName ===
                                                'user_phone' &&
                                                coreField.isVisible === '1'
                                            )" :key="index">
                  <ps-label class="text-base">{{ $t(coreField.labelName) }}
                    <span v-if="(coreField.mandatory = 1)" class="text-feError-800 font-medium ms-1">*</span></ps-label>
                  <div class="flex flex-row">

                    <input type="text" readonly class="block bg-transparent w-[50px] px2 py-2 text-sm shadow-sm dark:placeholder-feAchromatic-600 placeholder-feAchromatic-200
                                          text-feSecondary-500 dark:bg-transparent placeholder-feSecondary-800 dark:placeholder-feSecondary-500
                                          border border-feSecondary-200 hover:border-feSecondary-400 dark:border-feSecondary-400 hover:dark:border-feSecondary-50 focus:outline-none focusr_border-none focus:ring-2 focus:ring-fePrimary-300 ring-fePrimary-300 placeholder-feSecondary-500 dark:placeholder-feSecondary-400
                                          " value="+41" />
                    <ps-input type="tel" maxlength=10 v-bind:placeholder="$t(
                      'edit_profile__phone_placeholder'
                    )" v-model:value="tempPhone" @keypress="phoneNumber($event)"
                      class="placeholder-feSecondary-800 dark:placeholder-feSecondary-500 dark:bg-transparent "
                      defaultBorder="border border-feSecondary-200 hover:border-feSecondary-400 dark:border-feSecondary-400 hover:dark:border-feSecondary-50 focus:outline-none focusr_border-none focus:ring-2 focus:ring-fePrimary-300 ring-fePrimary-300 placeholder-feSecondary-500 dark:placeholder-feSecondary-400" />
                  </div>
                  <ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500" v-if="phoneStatus">
                    {{
                      $t(
                        "item_entry__phone_required_error"
                      )
                    }}
                  </ps-label>
                </div>

                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("credit_card_view__state") }}
                    <span class="text-feError-800 font-medium ms-1">*</span></ps-label>
                  <ps-input ref="state" type="text" v-model:value="holder.state
                    " class="dark:bg-transparent" />
                </div>

              </div>
              <div class="flex flex-col w-full">
                <div class="mb-6" v-for="(
                                            coreField, index
                                        ) in customFieldStore.customField.data?.coreList.filter(
                                              (coreField) =>
                                                coreField.fieldName === 'name' &&
                                                coreField.isVisible === '1'
                                            )" :key="index">
                  <ps-label class="text-base">{{ $t(coreField.labelName) }}
                    <span v-if="(coreField.mandatory = 1)" class="text-feError-800 font-medium ms-1">*</span></ps-label>
                  <ps-input ref="name" type="text" v-model:value="holder.name" class="dark:bg-transparent"
                    :placeholder="$t(coreField.placeholder)" @keypress="nameStatus = false" />
                  <ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500" v-if="nameStatus">
                    {{
                      $t(
                        "item_entry__name_required_error"
                      )
                    }}
                  </ps-label>
                </div>

                <!-- for User about me -->
                <!-- <div class="mb-6" v-for="(
                                            coreField, index
                                        ) in customFieldStore.customField.data?.coreList.filter(
                                              (coreField) =>
                                                coreField.fieldName ===
                                                'user_about_me' &&
                                                coreField.isVisible === '1'
                                            )" :key="index">
                  <ps-label class="text-base">{{ $t(coreField.labelName) }}
                    <span v-if="(coreField.mandatory = 1)" class="text-feError-800 font-medium ms-1">*</span></ps-label>
                  <ps-textarea rows="4" v-model:value="holder.userAboutMe" class="dark:bg-transparent"
                    :placeholder="$t(coreField.placeholder)" @keypress="aboutStatus = false" />
                  <ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500" v-if="aboutStatus">
                    {{
                      $t(
                        "item_entry__about_me_required_error"
                      )
                    }}
                  </ps-label>
                </div> -->

                <!-- <div v-for="customFieldHeader in customFieldStore
                  .customField.data?.customList" :key="customFieldHeader.id">
                 
                  <div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00001' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete === '0'
                  ">
                    <ps-label class="text-base">{{ $t(customFieldHeader.name)
                      }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        1
                        ">*</span></ps-label>
                    <ps-dropdown align="left" class="lg:mt-2 mt-1 w-full" @onClick="
                      loadCustomField(
                        customFieldHeader.coreKeysId
                      )
                      ">
                      <template #select>
                        <ps-dropdown-select :showCenter="true" :selectedValue="customizeUiStoreList.data
                          .filter(
                            (
                              customizeDetail
                            ) =>
                              customizeDetail.id ===
                              customFieldHeader.coreKeysId
                          )[0]
                          ?.provider?.customizeUiList.data?.filter(
                            (customField) =>
                              customField.id ===
                              form
                                .product_relation[
                              customFieldHeader
                                .coreKeysId
                              ]
                          )[0]?.name
                          " />
                      </template>
<template #list>
                        <div class="rounded-md shadow-xs w-56">
                          <div class="pt-2 z-30">
                            <div v-if="
                              customizeUiStoreList.data.filter(
                                (
                                  customizeDetail
                                ) =>
                                  customizeDetail.id ===
                                  customFieldHeader.coreKeysId
                              )[0]?.provider
                                ?.customizeUiList
                                .data ==
                              null
                            ">
                              <ps-label class="p-2 flex" @click="
                                loadCustomField(
                                  customFieldHeader.coreKeysId
                                )
                                ">{{
                                  $t(
                                    "item_entry__loading"
                                  )
                                }}
                              </ps-label>
                            </div>
                            <div v-else>
                              <div v-for="selectData in customizeUiStoreList.data.filter(
                                (
                                  customizeDetail
                                ) =>
                                  customizeDetail.id ===
                                  customFieldHeader.coreKeysId
                              )[0]?.provider
                                ?.customizeUiList
                                .data" :key="selectData.coreKeysId
                                  "
                                class="w-56 flex py-4 px-2 hover:bg-fePrimary-50 dark:hover:bg-fePrimary-900 cursor-pointer items-center"
                                @click="
                                  selectCustomDropdown(
                                    customFieldHeader.coreKeysId,
                                    selectData.id
                                  )
                                  ">
                                <ps-label class="ms-2" :class="form
                                  .product_relation[
                                  customFieldHeader
                                    .coreKeysId
                                ] ==
                                  selectData.id
                                  ? 'font-bold'
                                  : ''
                                  ">
                                  {{
                                    selectData.name
                                  }}
                                </ps-label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </template>
<template #loadmore>
                        <div class="mb-2 w-56">
                          <div v-if="
                            customizeUiStoreList.data.filter(
                              (
                                customizeDetail
                              ) =>
                                customizeDetail.id ===
                                customFieldHeader.coreKeysId
                            )[0]?.provider
                              ?.customizeUiList
                              .data != null &&
                            customizeUiStoreList.data.filter(
                              (
                                customizeDetail
                              ) =>
                                customizeDetail.id ===
                                customFieldHeader.coreKeysId
                            )[0]?.provider
                              ?.loading
                              .value == true
                          " class="mt-4 ms-4 flex">
                            <ps-label>
                              {{
                                $t(
                                  "item_entry__loading"
                                )
                              }}</ps-label>
                          </div>

                          <ps-label class="flex mt-4 ms-4 mb-2 underline font-bold cursor-pointer" v-if="
                            !customizeUiStoreList.data.filter(
                              (
                                customizeDetail
                              ) =>
                                customizeDetail.id ===
                                customFieldHeader.coreKeysId
                            )[0]?.provider
                              ?.isNoMoreRecord
                          " @click="
                            loadCustomField(
                              customFieldHeader.coreKeysId
                            )
                            ">
                            {{
                              $t(
                                "item_entry__load_more"
                              )
                            }}
                          </ps-label>
                        </div>
                      </template>
</ps-dropdown>
<ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500">{{
  product_relation_errors &&
  product_relation_errors[
  customFieldHeader.coreKeysId
  ]
  }}</ps-label>
</div>


<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00002' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete === '0'
                  ">
  <ps-label>{{ $t(customFieldHeader.name)
    }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        '1'
                        ">*</span></ps-label>
  <ps-input type="text" class="w-full dark:bg-transparent rounded" :placeholder="$t(
                      customFieldHeader.placeholder
                    )
                      " v-model:value="form.product_relation[
                        customFieldHeader.coreKeysId
                      ]
                        " @keypress="
                          validateCustom(
                            customFieldHeader.coreKeysId
                          )
                          " />
  <ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>


<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00003' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete === '0'
                  ">
  <ps-label class="text-base">{{ $t(customFieldHeader.name)
    }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        '1'
                        ">*</span></ps-label>
  <div class="flex flex-col">
    <div class="mb-1" v-for="detail in customizeUiStoreList.data.filter(
                        (customizeDetail) =>
                          customizeDetail.id ===
                          customFieldHeader.coreKeysId
                      )[0]?.provider?.customizeUiList
                        .data" :key="detail.id">
      <ps-radio-value-2 color="text-purple-600 border-purple-300" @change="
                          validateCustom(
                            customFieldHeader.coreKeysId
                          )
                          " v-model:value="form.product_relation[
                            customFieldHeader
                              .coreKeysId
                          ]
                            " :title="detail.name" />
      <ps-label :for="detail.id">{{
        detail.attribute
        }}</ps-label>
    </div>
  </div>
  <ps-label textColor="text-feError-500 " class="lg:mt-2 mt-1 w-full text-xs">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>


<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00004' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete ===
                    '0' &&
                    customFieldHeader.coreKeysId !=
                    'ps-usr00002'
                  ">
  <ps-label class="mb-1">{{
    $t(customFieldHeader.name)
    }}</ps-label>
  <div class="flex flex-row">
    <div class="me-2 flex">
      <input type="checkbox" class="rounded border" value="0" v-model="form.product_relation[
                          customFieldHeader
                            .coreKeysId
                        ]
                          " @change="
                            validateCustom(
                              customFieldHeader.coreKeysId
                            )
                            " />
      <ps-label class="ms-2">{{
        $t(
        customFieldHeader.placeholder
        )
        }}</ps-label>
    </div>
  </div>
  <ps-label textColor="text-feError-500 " class="lg:mt-2 mt-1 w-full text-xs">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>


<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00005' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete === '0'
                  ">
  <ps-label class="text-base">{{ $t(customFieldHeader.name)
    }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        '1'
                        ">*</span></ps-label>
  <div v-if="date_picker">
    <date-picker v-model:value="form.product_relation[
                        customFieldHeader
                          .coreKeysId
                      ]
                        " @change="
                          validateCustom(
                            customFieldHeader.coreKeysId
                          )
                          " :enableTimePicker="true" :inline="false" :autoApply="false" />
  </div>
  <ps-label textColor="text-feError-500 " class="lg:mt-2 mt-1 w-full text-xs">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>


<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00006' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete ===
                    '0' &&
                    customFieldHeader.coreKeysId !=
                    'ps-usr00003'
                  ">
  <ps-label class="text-base">{{ $t(customFieldHeader.name)
    }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        '1'
                        ">*</span></ps-label>
  <ps-textarea rows="4" :placeholder="$t(
                      customFieldHeader.placeholder
                    )
                      " v-model:value="form.product_relation[
                        customFieldHeader.coreKeysId
                      ]
                        " @keypress="
                          validateCustom(
                            customFieldHeader.coreKeysId
                          )
                          " />
  <ps-label textColor="text-feError-500 " class="lg:mt-2 mt-1 w-full text-xs">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>

<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00007' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete === '0'
                  ">
  <ps-label class="text-base">{{ $t(customFieldHeader.name)
    }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        '1'
                        ">*</span></ps-label>
  <ps-input type="number" class="w-full rounded" :placeholder="$t(
                      customFieldHeader.placeholder
                    )
                      " v-model:value="form.product_relation[
                        customFieldHeader.coreKeysId
                      ]
                        " @keypress="
                          validateCustom(
                            customFieldHeader.coreKeysId
                          )
                          " />
  <ps-label textColor="text-feError-500 " class="lg:mt-2 mt-1 w-full text-xs">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>

<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00008' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete === '0'
                  ">
  <ps-label class="text-base">{{ $t(customFieldHeader.name)
    }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        '1'
                        ">*</span></ps-label>
  <div class="flex flex-col">
    <CheckBox :oldData="form.product_relation[
                        customFieldHeader
                          .coreKeysId
                      ]
                        " @toParent="handleMultiSelect" :customizeDetails="customizeUiStoreList.data?.filter(
                          (customizeDetail) =>
                            customizeDetail?.id ===
                            customFieldHeader?.coreKeysId
                        )[0]?.provider
                          ?.customizeUiList.data
                          " :customizeHeader="customFieldHeader
                            " />
  </div>
  <ps-label textColor="text-feError-500 " class="lg:mt-2 mt-1 w-full text-xs">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>

<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00010' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete === '0'
                  ">
  <ps-label class="text-base">{{ $t(customFieldHeader.name)
    }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        '1'
                        ">*</span></ps-label>
  <input type="time" class="w-full rounded" v-model="form.product_relation[
                      customFieldHeader.coreKeysId
                    ]
                      " @keypress="
                        validateCustom(
                          customFieldHeader.coreKeysId
                        )
                        " />
  <ps-label textColor="text-feError-500 " class="lg:mt-2 mt-1 w-full text-xs">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>

<div class="mb-6" v-if="
                    customFieldHeader.uiType
                      .coreKeysId === 'uit00011' &&
                    customFieldHeader.isVisible ===
                    '1' &&
                    customFieldHeader.isDelete === '0'
                  ">
  <ps-label class="text-base">{{ $t(customFieldHeader.name)
    }}<span class="text-feError-800 font-medium ms-1" v-show="customFieldHeader.mandatory ==
                        '1'
                        ">*</span></ps-label>
  <div v-if="date_picker">
    <date-picker v-model:value="form.product_relation[
                        customFieldHeader
                          .coreKeysId
                      ]
                        " @change="
                          validateCustom(
                            customFieldHeader.coreKeysId
                          )
                          " :inline="false" :autoApply="false" />
  </div>
  <ps-label textColor="text-feError-500 " class="lg:mt-2 mt-1 w-full text-xs">{{
    product_relation_errors &&
    product_relation_errors[
    customFieldHeader.coreKeysId
    ]
    }}</ps-label>
</div>
</div> -->

                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("core__be_city") }}
                    <span class="text-feError-800 font-medium ms-1">*</span></ps-label>
                  <ps-input readonly ref="city" type="text" v-model:value="holder.city" class="dark:bg-transparent" />
                </div>
                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("country_placeholder") }}
                    <span class="text-feError-800 font-medium ms-1">*</span></ps-label>
                  <ps-input readonly ref="country" type="text" v-model:value="holder.country"
                    class="dark:bg-transparent" />
                </div>
              </div>
            </div>
            <h4 class="font-semibold my-7 dark:text-feSecondary-300">
              {{ $t("profile__bank_details") }}
            </h4>
            <div class="sm:grid grid-cols-2 w-full gap-6">
              <div class="flex flex-col w-full">
                <!-- account holder -->
                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("user__account_name") }}</ps-label>
                  <ps-input ref="accountName" type="text" v-model:value="bankHolder.accountHolderName
                    " class="dark:bg-transparent w-84" />
                </div>
                <!-- bank name -->
                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("user__bank_name") }}</ps-label>
                  <ps-input ref="bankName" type="text" v-model:value="bankHolder.bankName"
                    class="dark:bg-transparent w-84" />
                </div>
                <!-- bank branch -->
                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("user__bank_branch") }}</ps-label>
                  <ps-input ref="accountName" type="text" v-model:value="bankHolder.bankBranch"
                    class="dark:bg-transparent w-84" />
                  <!-- <ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500"
                                                                      v-if="bankBranchStatus">
                                                                      {{
                                                                      $t(
                                                                      "item_entry__accountname_required_error"
                                                                      )
                                                                      }}
                                                                  </ps-label> -->
                </div>
                <!-- country name -->
                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("user__bank_country_name") }}</ps-label>
                  <ps-input ref="accountName" type="text" v-model:value="bankHolder.countryName"
                    class="dark:bg-transparent w-84" />
                  <!-- <ps-label class="lg:mt-2 mt-1 w-full text-xs" textColor="text-feError-500"
                                                                      v-if="bankBranchStatus">
                                                                      {{
                                                                      $t(
                                                                      "item_entry__accountname_required_error"
                                                                      )
                                                                      }}
                                                                  </ps-label> -->
                </div>
              </div>
              <div class="flex flex-col w-full">
                <!-- acc no -->
                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("user__account_number") }}</ps-label>
                  <ps-input ref="accountName" type="text" v-model:value="bankHolder.accountNumber"
                    class="dark:bg-transparent w-84" />
                </div>

                <!-- bank code -->
                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("user__bank_code") }}</ps-label>
                  <ps-input ref="bankCode" type="text" v-model:value="bankHolder.bankCode"
                    class="dark:bg-transparent w-84" />
                </div>

                <!-- bank address -->
                <div class="mb-6">
                  <ps-label class="text-base">{{ $t("user__bank_address") }}</ps-label>
                  <ps-input ref="accountName" type="text" v-model:value="bankHolder.address"
                    class="dark:bg-transparent w-84" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end mt-4 sm:mt-12 md:mt-16 lg:mt-20 mb-6 sm:mb-8">
          <ps-button class="text-center w-52 me-0 sm:me-6 text-feSecondary-800 dark:text-feSecondary-50" border="border"
            colors="border border-feSecondary-200 dark:border-feAchromatic-500"
            hover="hover:bg-feSecondary-50 hover:dark:bg-feAchromatic-900 hover:dark:border-feAchromatic-200 active:bg-feSecondary-50 active:dark:border-feAchromatic-500"
            @click="cancelClicked">
            {{ $t("edit_profile__cancel") }}
          </ps-button>
          <ps-button class="text-center w-52 mt-4 sm:mt-0" @click="isPhoneVerified">
            {{ $t("edit_profile__update") }}
          </ps-button>
        </div>
      </div>
    </template>
  </ps-content-container>

  <ps-loading-dialog ref="ps_loading_dialog" />

  <user-phone-login-verification-modal ref="user_phone_login_verification_modal" />

  <ps-error-dialog ref="ps_error_dialog" />
  <ps-success-dialog ref="ps_success_dialog" />
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
// Libs
import { onMounted, reactive, ref } from "vue";
// import router from '@template1/router';
import PsDropdown from "@template1/vendor/components/core/dropdown/PsDropdown.vue";
import PsDropdownSelect from "@template1/vendor/components/core/dropdown/PsDropdownSelect.vue";
// Providers
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
// import { createUserStateListProviderState } from '@templateCore/store/modules/user/UserStateProvider';
import { usePhoneStore } from "@templateCore/store/modules/item/PhoneStore";
import { useCustomFieldStoreState } from "@templateCore/store/modules/customField/CustomFieldStore";
import { useCustomizeUiStoreState } from "@templateCore/store/modules/customField/CustomizeUiStore";

// Components
import PsInputWithRightIcon from "@template1/vendor/components/core/input/PsInputWithRightIcon.vue";
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelHeader4 from "@template1/vendor/components/core/label/PsLabelHeader4.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsTextarea from "@template1/vendor/components/core/textarea/PsTextarea.vue";
// import PsTextarea from "@/Components/Core/Textarea/PsTextarea.vue";

import PsCheckboxValue from "@template1/vendor/components/core/checkbox/PsCheckboxValue.vue";
import ProfileUpdateViewHolder from "@templateCore/object/holder/ProfileUpdateViewHolder";
import PsStatus from "@templateCore/api/common/PsStatus";
import PsLoadingDialog from "@template1/vendor/components/core/dialogs/PsLoadingDialog.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialogs/PsErrorDialog.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialogs/PsSuccessDialog.vue";
import UserPhoneLoginVerificationModal from "@template1/vendor/components/modules/user/UserPhoneLoginVerificationModal.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsLabelTitle3 from "@template1/vendor/components/core/label/PsLabelTitle3.vue";
import DatePicker from "@template1/vendor/components/core/datetime/DatePicker.vue";
import PsRadioValue2 from "@template1/vendor/components/core/radio/PsRadioValue2.vue";
import CheckBox from "@template1/vendor/components/core/checkbox/CheckBox.vue";
import PsBreadcrumb2 from "@template1/vendor/components/core/breadcrumbs/PsBreadcrumb2.vue";

import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import firebaseApp from "firebase/app";
import "firebase/auth";
// language
import { trans } from "laravel-vue-i18n";
import PsUtils from "@templateCore/utils/PsUtils";
import PsConst from "@templateCore/object/constant/ps_constants";
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";

export default {
  name: "EditProfileView",
  components: {
    PsContentContainer,
    PsButton,
    PsLabelHeader4,
    PsIcon,
    PsInput,
    PsTextarea,
    PsCheckboxValue,
    PsLabelTitle3,
    PsLoadingDialog,
    PsErrorDialog,
    UserPhoneLoginVerificationModal,
    PsLabel,
    PsRouteLink,
    Head,
    PsDropdownSelect,
    PsDropdown,
    PsInputWithRightIcon,
    DatePicker,
    PsRadioValue2,
    CheckBox,
    PsBreadcrumb2,
    PsSuccessDialog,
  },
  layout: PsFrontendLayout,
  setup() {
    // Providers
    const userStore = useUserStore();

    // Init Variables
    const psValueStore = PsValueStore();
    const loginUserId = psValueStore.getLoginUserId();

    if (
      loginUserId == null ||
      loginUserId == "" ||
      loginUserId == PsConst.NO_LOGIN_USER
    ) {
      router.get(route("login"));
    }

    const previewImage = reactive({
      data: [] as any,
    });
    let selectedFile;
    const bankHolder = ref({
      accountHolderName: "",
      accountNumber: "",
      address: "",
      bankBranch: "",
      bankCode: "",
      bankName: "",
      countryName: "",
      userId: loginUserId,
    });
    const holder = reactive(new ProfileUpdateViewHolder());
    const date_picker = ref(false);

    const date = new Date();
    date.setFullYear(date.getFullYear() - 18);
    const pickedDate = ref();
    const upperDate = ref(date);
    const image = ref();
    const profilePhoto = ref("");
    const ps_loading_dialog = ref();
    const ps_error_dialog = ref();
    const ps_success_dialog = ref();
    const user_phone_login_verification_modal = ref();
    let oldUser;
    const phoneStore = usePhoneStore();

    const phoneKeyword = ref("");
    const countryCode = ref("+41");
    const tempPhone = ref("");

    const customFieldStore = useCustomFieldStoreState("user_edit");
    const customizeUiStoreList = reactive({
      data: [
        {
          id: "default",
          provider: useCustomizeUiStoreState("default"),
        },
      ],
    });

    let form = useForm({
      product_relation: {},
    });
    let product_relation_errors = ref({});

    const userNameStatus = ref(false);
    const emailStatus = ref(false);
    const phoneStatus = ref(false);
    const aboutStatus = ref(false);
    const nameStatus = ref(false);
    let bankDataRef = firebaseApp.database().ref().child("BankDetail");
    // Functions
    onMounted(async () => {
      bankDataRef
        .child(`bankDetail_${loginUserId}`)
        .on("value", (snapshot) => {
          const data = snapshot.val();
          if (data) {
            bankHolder.value = {
              accountHolderName: data.accountHolderName || "",
              accountNumber: data.accountNumber || "",
              address: data.address || "",
              bankBranch: data.bankBranch || "",
              bankCode: data.bankCode || "",
              bankName: data.bankName || "",
              countryName: data.countryName || "",
              userId: data.userId || loginUserId,
            };
          }
        });
      await customFieldStore.loadUserCustomFieldList(loginUserId);

      // console.log(
      //   "customFieldStore.customField.data.coreList,",
      //   customFieldStore.customField.data.coreList
      // );

      for (const customField of customFieldStore.customField.data
        ?.customList) {
        // for dropdown
        if (
          customField.isVisible == "1" &&
          customField.isDelete == "0" &&
          customField.uiType.coreKeysId == "uit00001"
        ) {
          customizeUiStoreList.data.push({
            id: customField.coreKeysId,
            provider: useCustomizeUiStoreState(
              customField.coreKeysId
            ),
          });
        }

        // for radio
        if (
          customField.isVisible == "1" &&
          customField.isDelete == "0" &&
          customField.uiType.coreKeysId == "uit00003"
        ) {
          customizeUiStoreList.data.push({
            id: customField.coreKeysId,
            provider: useCustomizeUiStoreState(
              customField.coreKeysId
            ),
          });
          loadCustomField(customField.coreKeysId);
        }

        // for multi select
        if (
          customField.isVisible == "1" &&
          customField.isDelete == "0" &&
          customField.uiType.coreKeysId == "uit00008"
        ) {
          customizeUiStoreList.data.push({
            id: customField.coreKeysId,
            provider: useCustomizeUiStoreState(
              customField.coreKeysId
            ),
          });
          loadCustomField(customField.coreKeysId);
        }
      }

      loadUserData();
      loadAppVerifier();
    });

    function validateCustom(id) {
      product_relation_errors.value[id] = "";
    }

    function loadCustomField(coreKeysId) {
      customizeUiStoreList.data
        .filter(
          (customizeDetail) => customizeDetail.id === coreKeysId
        )[0]
        .provider.loadCustomFieldList("1", coreKeysId);
    }

    async function loadUserData() {
      ps_loading_dialog.value.openModal();
      const returnData = await userStore.loadUser(loginUserId);
      oldUser = returnData.data;

      ps_loading_dialog.value.closeModal();
      if (returnData.status == PsStatus.SUCCESS) {
        const userInfo = returnData.data;
        // console.log("userInfo: ",userInfo,returnData.data)
        holder.userId = userInfo.userId;
        holder.userName = userInfo.username;
        holder.name = userInfo.userName;
        holder.userEmail = userInfo.userEmail;

        holder.city = userInfo.city;
        holder.userAboutMe = userInfo.userAboutMe;
        holder.userAddress = userInfo.userAddress;
        holder.state = userInfo.state;
        holder.country = userInfo.country;

        holder.isShowEmail = userInfo.isShowEmail;
        holder.isShowEmailBool = holder.isShowEmail == "1";
        holder.isShowPhone = userInfo.isShowPhone;
        holder.isShowPhoneBool = holder.isShowPhone == "1";
        profilePhoto.value = userInfo.userCoverPhoto.toString();

        if (userInfo.userPhone != "") {
          const phoneArray = userInfo.userPhone.split("-");
          if (phoneArray.length > 1) {
            countryCode.value = phoneArray[0];
            tempPhone.value = phoneArray[1];
          } else {
            tempPhone.value = phoneArray[0];
          }
        }

        holder.userPhone = countryCode.value + "" + tempPhone.value;

        const userRelation = userInfo.userRelation;

        if (userRelation != null && userRelation.length > 0) {
          userRelation.forEach((customField) => {
            if (customField.uiTypeId == "uit00004") {
              if (customField.value == 1) {
                form.product_relation[customField.coreKeysId] =
                  true;
              } else {
                form.product_relation[customField.coreKeysId] =
                  false;
              }
            } else if (
              customField.uiTypeId == "uit00005" ||
              customField.uiTypeId == "uit00011"
            ) {
              form.product_relation[customField.coreKeysId] =
                new Date(customField.value);
            } else {
              form.product_relation[customField.coreKeysId] =
                customField.value;
            }

            if (customField.uiTypeId == "uit00001") {
              loadCustomField(customField.coreKeysId);
            }
          });
        }

        date_picker.value = true;
      } else {
        ps_error_dialog.value.openModal(
          trans("ps_error_dialog__error"),
          returnData.message,
          trans("edit_profile__ok"),
          () => { }
        );
        // router.push({ name : "dashboard"});
      }
    }

    function phoneNumber(evt) {
      evt = evt ? evt : window.event;
      const charCode = evt.which ? evt.which : evt.keyCode;

      if (charCode < 42 || charCode > 57) {
        evt.preventDefault();
      } else {
        phoneStatus.value = false;
        return true;
      }
    }

    function isNumber(evt) {
      evt = evt ? evt : window.event;
      const charCode = evt.which ? evt.which : evt.keyCode;
      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57) &&
        charCode !== 46
      ) {
        evt.preventDefault();
      } else {
        return true;
      }
    }

    function onImageSelected(event) {
      const selectedFiles = event.target.files;

      if (selectedFiles && selectedFiles.length > 1) {
        window.alert("Over 5");
      } else {
        previewImage.data = [];
        for (let i = 0; i < selectedFiles.length; i++) {
          const reader = new FileReader();
          reader.onload = (e) => {
            (previewImage.data as string[]).push(
              e.target
                ? e.target.result
                  ? e.target.result.toString()
                  : ""
                : ""
            );
          };
          reader.readAsDataURL(selectedFiles[i]);
          selectedFile = selectedFiles[i];
        }
      }
    }

    function onImageClick() {
      image.value.click();
    }

    function uploadImage() {
      userStore.postImageUpload(
        psValueStore.getLoginUserId(),
        "web",
        selectedFile,
        ""
      );
    }

    async function submit() {
      holder.userRelation = [];

      let coreKeysIds = Object.keys(form.product_relation);
      coreKeysIds.forEach((coreKeysId) => {
        holder.userRelation.push({
          core_keys_id: coreKeysId,
          value: form.product_relation[coreKeysId],
        });
      });

      holder.isShowEmail = holder.isShowEmailBool ? "1" : "0";
      holder.isShowPhone = holder.isShowPhoneBool ? "1" : "0";

      ps_loading_dialog.value.openModal();
      ps_loading_dialog.value.setMessage(
        trans("edit_profile__updating_profile")
      );
      const returnData = await userStore.postProfileUpdate(
        holder,
        loginUserId
      );

      bankDataRef
        .child(`bankDetail_${loginUserId}`)
        .set(bankHolder.value);

      if (selectedFile != undefined) {
        ps_loading_dialog.value.setMessage(
          trans("edit_profile__uploading_profile_image")
        );
        await userStore.postImageUpload(
          psValueStore.getLoginUserId(),
          "web",
          selectedFile,
          ""
        );
      }
      ps_loading_dialog.value.closeModal();

      if (returnData.status == PsStatus.SUCCESS) {
        ps_success_dialog.value.openModal(
          trans("edit_profile__success"),
          trans("edit_profile__profile_updated"),
          trans("edit_profile__ok"),
          () => { }
        );
      } else if (returnData.status == PsStatus.ERROR) {
        ps_error_dialog.value.openModal(
          trans("ps_error_dialog__error"),
          returnData.message,
          trans("edit_profile__ok"),
          () => { }
        );
      }
    }

    function isPhoneVerified() {
      let errorStatus = true;

      customFieldStore.customField.data?.coreList.forEach((coreField) => {
        if (
          coreField.fieldName === "username" &&
          (holder.userName == "" || holder.userName == undefined) &&
          coreField.isVisible == "1" &&
          coreField.mandatory == 1
        ) {
          userNameStatus.value = true;
          errorStatus = false;
        }

        if (
          coreField.fieldName === "email" &&
          (holder.userEmail == "" || holder.userEmail == undefined) &&
          coreField.isVisible == "1" &&
          coreField.mandatory == 1
        ) {
          emailStatus.value = true;
          errorStatus = false;
        }

        if (
          coreField.fieldName === "name" &&
          (holder.name == "" || holder.name == undefined) &&
          coreField.isVisible == "1" &&
          coreField.mandatory == 1
        ) {
          nameStatus.value = true;
          errorStatus = false;
        }

        if (
          coreField.fieldName === "user_phone" &&
          (tempPhone.value == "" || tempPhone.value == undefined) &&
          coreField.isVisible == "1" &&
          coreField.mandatory == 1
        ) {
          phoneStatus.value = true;
          errorStatus = false;
        }

        if (
          coreField.fieldName === "user_about_me" &&
          (holder.userAboutMe == "" ||
            holder.userAboutMe == undefined) &&
          coreField.isVisible == "1" &&
          coreField.mandatory == 1
        ) {
          aboutStatus.value = true;
          errorStatus = false;
        }
      });
      customFieldStore.customField.data?.customList.forEach(
        (customField) => {
          if (
            (form.product_relation[customField.coreKeysId] == "" ||
              form.product_relation[customField.coreKeysId] ==
              undefined) &&
            customField.isVisible == "1" &&
            customField.mandatory == "1" &&
            customField.isDelete == "0"
          ) {
            product_relation_errors.value[customField.coreKeysId] =
              customField.name +
              trans("item_entry__field_is_reqiured");
            errorStatus = false;
          } else if (
            form.product_relation[customField.coreKeysId] != "" &&
            form.product_relation[customField.coreKeysId] !=
            undefined &&
            customField.coreKeysId ==
            PsConst.WHATSAPP_CORE_KEY_Id &&
            !/^\+\d{2,}/.test(
              form.product_relation[customField.coreKeysId]
            )
          ) {
            product_relation_errors.value[customField.coreKeysId] =
              trans("whatsapp_required_countrycode");
            errorStatus = false;
          }
        }
      );

      // End
      if (errorStatus != true) {
        window.scrollTo(0, 0);
        return;
      }

      if (tempPhone.value == "") {
        holder.userPhone = "";
      } else {
        holder.userPhone = countryCode.value + "-" + tempPhone.value;
      }

      if (holder.userPhone == oldUser.userPhone) {
        submit();
      } else {
        phoneVerificatrion(countryCode.value + "" + tempPhone.value);
      }
    }
    let appVerifier;
    function loadAppVerifier() {
      // Init recaptchaVerifier
      ps_loading_dialog.value.openModal();
      setTimeout(() => {
        (window as any).recaptchaVerifier =
          new firebaseApp.auth.RecaptchaVerifier(
            "recaptcha-container",
            {
              size: "invisible",
              callback: (response) => {
                PsUtils.log("Callback");
                PsUtils.log(response);
              },
              "expired-callback": () => {
                PsUtils.log("expiry callback");
              },
            }
          );

        appVerifier = (window as any).recaptchaVerifier;
        ps_loading_dialog.value.closeModal();
      }, 500);
    }

    async function phoneVerificatrion(phone) {
      ps_loading_dialog.value.openModal();
      const verifier = appVerifier;
      const confirmationResult = await firebaseApp
        .auth()
        .signInWithPhoneNumber(phone, verifier)
        .catch((error) => {
          ps_loading_dialog.value.closeModal();

          ps_error_dialog.value.openModal(
            trans("edit_profile__error_in_changing_phone_number"),
            error?.message,
            trans("edit_profile__ok"),
            () => { }
          );
        });
      ps_loading_dialog.value.closeModal();

      if (confirmationResult != undefined) {
        user_phone_login_verification_modal.value.openModal(
          trans("phone_no_verification_modal__title"),
          // 'Phone No Verification',
          "",
          "Submit",
          "Cancel",
          async (code) => {
            ps_loading_dialog.value.openModal();
            confirmationResult
              .confirm(code)
              .then(async (userCredential) => {
                if (
                  userCredential != null &&
                  userCredential.user != null &&
                  userCredential.user.uid != null &&
                  userCredential.user.uid != ""
                ) {
                  // call backend server
                  ps_loading_dialog.value.closeModal();
                  submit();
                } else {
                  PsUtils.log("ERROR");
                }
              })
              .catch((error) => {
                // User couldn't sign in (bad verification code?)
                ps_loading_dialog.value.closeModal();
                ps_error_dialog.value.openModal(
                  trans(
                    "edit_profile__error_in_changing_phone_number"
                  ),
                  error?.message,
                  trans("edit_profile__ok"),
                  () => { }
                );
              });
          },
          () => {
            PsUtils.log("Cancel");
          }
        );
      }
    }

    function loadPhone() {
      phoneStore.loadPhoneCountryCode(
        loginUserId,
        phoneStore.phoneparamHolder
      );
    }

    function filterPhoneUpdate(value) {
      phoneStore.phoneparamHolder.keyword = value;
      // subcatHolder.keyword = value;
      phoneStore.filterPhoneUpdate(
        loginUserId,
        phoneStore.phoneparamHolder
      );
    }

    function phoneFilterClicked(value) {
      countryCode.value = value.country_code;
    }

    function cancelClicked() {
      router.get(route("fe_profile"));
    }

    function selectCustomDropdown(coreKeysId, id) {
      form.product_relation[coreKeysId] = id;
      validateCustom(coreKeysId);
    }

    return {
      phoneFilterClicked,
      filterPhoneUpdate,
      // userStateListProvider,
      loadPhone,
      phoneStore,
      previewImage,
      onImageSelected,
      uploadImage,
      userStore,
      submit,
      holder,
      date_picker,
      pickedDate,
      // loadStateList,
      image,
      onImageClick,
      profilePhoto,
      ps_loading_dialog,
      ps_error_dialog,
      ps_success_dialog,
      upperDate,
      phoneNumber,
      isNumber,
      user_phone_login_verification_modal,
      isPhoneVerified,
      phoneKeyword,
      countryCode,
      tempPhone,
      form,
      customFieldStore,
      customizeUiStoreList,
      userNameStatus,
      emailStatus,
      aboutStatus,
      phoneStatus,
      nameStatus,
      validateCustom,
      product_relation_errors,
      cancelClicked,
      loadCustomField,
      selectCustomDropdown,
      bankHolder,
    };
  },
  computed: {
    breadcrumb() {
      return [
        {
          label: this.userStore.user.data?.userName,
          url: route("fe_profile"),
        },
        {
          label: trans("edit_profile__edit_profile"),
          color: "text-fePrimary-500",
        },
      ];
    },
  },
};
</script>
