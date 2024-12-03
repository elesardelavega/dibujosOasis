System.register([],(function(e,t){"use strict";return{execute:function(){var e=document.createElement("style");e.textContent='.acfw-block-single-coupon .components-placeholder__fieldset{flex-flow:column}.acfw-block-single-coupon .components-placeholder__fieldset .acfw-single-block-fields{display:flex;flex-flow:row;margin-top:1em;padding-top:1em;border-top:1px solid #eee}.acfw-block-single-coupon .components-placeholder__fieldset .acfw-single-block-fields .acfw-block-current-coupon-selected{width:50%;max-width:220px}.acfw-block-single-coupon .components-placeholder__fieldset .acfw-single-block-fields .acfw-block-current-coupon-selected span{display:block}.acfw-block-single-coupon .components-placeholder__fieldset .acfw-single-block-fields .acfw-block-current-coupon-selected .coupon-code{display:inline-block;width:calc(100% - 10px);padding:.5em 1em;margin-top:.5em;font-weight:700;font-size:1.2em;line-height:1.3em;background:#e6e6e6;border-radius:5px;overflow:hidden}.acfw-block-single-coupon .components-placeholder__fieldset .acfw-single-block-fields .acfw-block-coupon__selection{position:relative;padding-right:3em;width:50%;max-width:400px}.acfw-block-single-coupon .components-placeholder__fieldset .acfw-single-block-fields .acfw-block-coupon__selection ul.components-form-token-field__suggestions-list{margin:0}.acfw-block-single-coupon .components-placeholder__fieldset .acfw-single-block-fields .acfw-block-coupon__selection span.components-spinner{position:absolute;top:2.5em;right:0}.acfw-coupon-categories{margin-top:10px}.acfw-coupon-categories__spinner{text-align:center}.acfw-coupon-categories__list{margin-bottom:1em;padding:5px 15px;max-height:200px;overflow:auto;border:1px solid #ccc}.acfw-coupon-categories__item .components-checkbox-control__label{display:inline-block;width:calc(100% - 40px)}.acfw-block-coupons-category ul.woocommerce-search-list__list{margin:0}.acfw-block-coupons-category ul.woocommerce-search-list__list>li{border-bottom:1px solid #f1f1f1}.acfw-block-coupons-category ul.woocommerce-search-list__list>li:last-child{border-bottom:0}.acfw-block-coupons-category ul.woocommerce-search-list__list>li .woocommerce-search-list__item{padding:7px 16px}.acfw-block-coupons-category .woocommerce-search-list__selected ul{margin:0;list-style:none}.acfw-block-coupons-category .woocommerce-search-list__selected ul li{display:inline-block}.acfw-block-coupons-customer .components-placeholder__fieldset>div{margin-bottom:1em}.acfw-block-coupons-customer.acfw-disabled-upsell .components-placeholder__fieldset{position:relative}.acfw-block-coupons-customer.acfw-disabled-upsell .components-placeholder__fieldset:after{content:"";position:absolute;top:0;left:0;z-index:10;display:block;width:100%;height:calc(100% - 40px);background:rgba(255,255,255,.4117647059)}.acfw-block-coupons-customer .acfw-upsell-message{width:100%;padding:5px 10px;margin-bottom:0!important;color:#fff;background:#34a0d2;border:1px solid #1c8fc3}.acfw-block-coupons-customer .acfw-upsell-message a{color:#e7f7ff;text-decoration:underline}.acfw-block-coupons-grid{padding:0 .5em}.acfw-block-coupons-grid .fullwidth-field{width:100%;padding:0 .5em}.acfw-block-coupons-grid .one-half-col{width:50%;padding:0 .5em}.acfw-block-coupons-grid .one-third-col{width:33.33333%;padding:0 .5em}\n',document.head.appendChild(e);const{contentDisplaySettings:t}=acfwfBlocksi18n,o=e=>{const{onChange:o,settings:c}=e,{discount_value:l,description:n,usage_limit:a,schedule:s}=c;return React.createElement(React.Fragment,null,React.createElement(wp.components.ToggleControl,{label:t.displayDiscountValue,checked:l,onChange:()=>o({...c,discount_value:!l})}),React.createElement(wp.components.ToggleControl,{label:t.displayDescription,checked:n,onChange:()=>o({...c,description:!n})}),React.createElement(wp.components.ToggleControl,{label:t.displayUsageLimit,checked:a,onChange:()=>o({...c,usage_limit:!a})}),React.createElement(wp.components.ToggleControl,{label:t.displaySchedule,checked:s,onChange:()=>o({...c,schedule:!s})}))},{searchAndSelectCouponLabel:c}=acfwfBlocksi18n,l=e=>{const{coupon_id:t,setAttributes:o}=e,[l,n]=wp.element.useState([]),[a,s]=wp.element.useState(""),[i,r]=wp.element.useState(null),[p,d]=wp.element.useState(!1),[m,u]=wp.element.useState(!1);return React.createElement("div",{className:"acfw-coupon-search-field-wrap"},React.createElement(wp.components.ComboboxControl,{label:c,value:t,onChange:e=>{const t=l.findIndex((t=>t.value===e));0<=t&&o({coupon_id:e,coupon_code:l[t].label})},options:l,onFilterValueChange:e=>{u(!1),i&&(clearTimeout(i),r(null)),e||d(!1),e.length<3||(p||d(!0),r(setTimeout((async()=>{try{a&&a!==e&&n([]);const t=await wp.apiFetch({path:`/wc/v3/coupons/?search=${e}`});t.length?n(t.map((e=>({value:e.id,label:e.code})))):u(!0),d(!1)}catch(t){console.log(t)}}),1e3)))}}),p&&React.createElement(wp.components.Spinner,null),m&&React.createElement("div",null,acfwfBlocksi18n.emptyCouponSearch))},{singleCouponTexts:n,contentDisplaySettings:a,currentlySelectedCouponLabel:s,doneBtnText:i}=acfwfBlocksi18n,r=wp.components.withSpokenMessages((e=>{const{attributes:t,name:c,setAttributes:r}=e,[p,d]=wp.element.useState(1>t.coupon_id);return React.createElement(React.Fragment,null,React.createElement(wp.blockEditor.BlockControls,null,React.createElement(wp.components.ToolbarGroup,{controls:[{icon:"edit",title:"Edit",onClick:()=>d(!p),isActive:p}]})),React.createElement(wp.blockEditor.InspectorControls,{key:"inspector"},React.createElement(wp.components.PanelBody,{title:a.title,initialOpen:!0},React.createElement(o,{settings:t.contentVisibility,onChange:e=>r({contentVisibility:e})}))),p?React.createElement(wp.components.Placeholder,{label:n.title,className:"acfw-block-single-coupon"},n.description,React.createElement("div",{className:"acfw-single-block-fields"},""!==t.coupon_code&&React.createElement("div",{className:"acfw-block-current-coupon-selected"},React.createElement("span",null,s),React.createElement("span",{className:"coupon-code",title:t.coupon_code},t.coupon_code)),React.createElement("div",{className:"acfw-block-coupon__selection"},React.createElement(l,{coupon_id:t.coupon_id,setAttributes:r}))),React.createElement("div",{className:"acfw-block-action-buttons"},React.createElement(wp.components.Button,{isPrimary:!0,onClick:()=>d(!1)},i))):React.createElement(React.Fragment,null,0<t.coupon_id?React.createElement(wp.serverSideRender,{block:c,attributes:t,EmptyResponsePlaceholder:()=>React.createElement(wp.components.Placeholder,{label:n.title,className:"acfw-block-single-coupon"},n.emptyDesc)}):React.createElement(wp.components.Placeholder,{label:n.title,className:"acfw-block-coupons-grid acfw-block-coupons-category"},React.createElement("p",null,n.selectDesc))))})),{orderTypeFieldTexts:p}=acfwfBlocksi18n,d=1,m=6,u=1,w=100,b=[{value:"date/desc",label:p.options.newestToOldest},{value:"date/asc",label:p.options.oldestToNewest},{value:"title/asc",label:p.options.aToZ},{value:"title/desc",label:p.options.zToA},{value:"expire/asc",label:p.options.earliestToExpire}],g={order_by:{type:"string",default:"date/desc"},columns:{type:"number",default:3},count:{type:"number",default:10}},f={contentVisibility:{type:"object",default:{discount_value:!0,description:!0,usage_limit:!0,schedule:!0}},isPreview:{type:"boolean",default:!1}},{singleCouponTexts:h}=acfwfBlocksi18n,k={name:"acfw/single-coupon",settings:{title:h.title,icon:"tickets-alt",category:"advancedcoupons",keywords:["coupon","advanced"],decription:h.description,supports:{align:["wide","full"],html:!1},example:{attributes:{isPreview:!0}},attributes:{coupon_id:{type:"number",default:0},coupon_code:{type:"string",default:""},...f},edit:e=>React.createElement(r,{...e}),save:()=>null}},{couponsCategoryTexts:_}=acfwfBlocksi18n,y=e=>{const{categories:t,setCategories:o,selected:c,onChange:l}=e,n=function(){const e=wp.element.useRef(!0),t=wp.element.useCallback((()=>e.current),[]);return wp.element.useEffect((()=>()=>{e.current=!1}),[]),t}();return wp.element.useEffect((()=>{0<t.length||wp.apiFetch({path:"/wp/v2/shop_coupon_cat?per_page=-1&order=desc&orderby=count"}).then((e=>{n&&o(e)}))}),[]),React.createElement("div",{className:"acfw-coupon-categories"},React.createElement("div",{className:"acfw-coupon-categories__label"},_.selectCategories),React.createElement("div",{className:"acfw-coupon-categories__list"},t.length?React.createElement(React.Fragment,null,t.map((e=>React.createElement("div",{className:"acfw-coupon-categories__item",key:e.id},React.createElement(wp.components.CheckboxControl,{label:`${e.name} (${e.count})`,checked:c.includes(e.id),onChange:t=>((e,t)=>{l(e?[...c,t.id]:c.filter((e=>e!==t.id)))})(t,e)}))))):React.createElement("div",{className:"acfw-coupon-categories__spinner"},React.createElement(wp.components.Spinner,null))))},{couponsCategoryTexts:R,orderTypeFieldTexts:E,numberofItemsFieldLabel:v,numberofColumnsFieldLabel:C,contentDisplaySettings:x,doneBtnText:T}=acfwfBlocksi18n,S=wp.components.withSpokenMessages((e=>{const{attributes:t,name:c,setAttributes:l,debouncedSpeak:n}=e,[a,s]=wp.element.useState(1>t.categories.length),[i,r]=wp.element.useState([]),p=t.categories.length>0;return React.createElement(React.Fragment,null,React.createElement(wp.blockEditor.BlockControls,null,React.createElement(wp.components.ToolbarGroup,{controls:[{icon:"edit",title:"Edit",onClick:()=>s(!a),isActive:a}]})),React.createElement(wp.blockEditor.InspectorControls,{key:"inspector"},React.createElement(wp.components.PanelBody,{title:x.title,initialOpen:!0},React.createElement(o,{settings:t.contentVisibility,onChange:e=>l({contentVisibility:e})}))),a?React.createElement(wp.components.Placeholder,{label:R.title,className:"acfw-block-coupons-grid acfw-block-coupons-category"},R.description,React.createElement("div",{className:"wc-block-coupon-category__selection fullwidth-field"},React.createElement(y,{categories:i,setCategories:r,selected:t.categories,onChange:(e=[])=>{l({categories:e})}})),React.createElement("div",{className:"order-by__selection one-third-col"},React.createElement(wp.components.SelectControl,{label:E.label,value:t.order_by,options:b,onChange:e=>l({order_by:e})})),React.createElement("div",{className:"items-count__range one-third-col"},React.createElement(wp.components.RangeControl,{label:v,value:t.count,onChange:e=>{const t=window.lodash.clamp(e,u,w);l({count:t})},min:u,max:w})),React.createElement("div",{className:"column-count__range one-third-col"},React.createElement(wp.components.RangeControl,{label:C,value:t.columns,onChange:e=>{const t=window.lodash.clamp(e,d,m);l({columns:t})},min:d,max:m})),React.createElement(wp.components.Button,{isPrimary:!0,onClick:()=>s(!1)},T)):React.createElement(React.Fragment,null,p?React.createElement(wp.serverSideRender,{block:c,attributes:t,EmptyResponsePlaceholder:()=>React.createElement(wp.components.Placeholder,{label:R.title,className:"acfw-block-coupons-grid acfw-block-coupons-category"},R.emptyDesc)}):React.createElement(wp.components.Placeholder,{label:R.title,className:"acfw-block-coupons-grid acfw-block-coupons-category"},React.createElement("p",null,R.selectDesc))))})),{couponsCategoryTexts:N}=acfwfBlocksi18n,B={name:"acfw/coupons-category",settings:{title:N.title,icon:"tickets-alt",category:"advancedcoupons",keywords:["coupon","advanced","category"],decription:N.description,supports:{align:["wide","full"],html:!1},example:{attributes:{isPreview:!0}},attributes:{categories:{type:"array",default:[]},...g,...f},edit:e=>React.createElement(S,{...e}),save:()=>null}},{isPremium:P,couponsCustomerTexts:F,displayTypeFieldTexts:A,orderTypeFieldTexts:D,numberofItemsFieldLabel:V,numberofColumnsFieldLabel:L,contentDisplaySettings:I,premiumUpsellMessage:M,doneBtnText:O}=acfwfBlocksi18n,z=wp.components.withSpokenMessages((e=>{const{attributes:t,name:c,setAttributes:l,debouncedSpeak:n}=e,[a,s]=wp.element.useState(""===t.display_type),i=[{value:"both",label:A.options.couponsAndVirtualCoupons},{value:"coupons_only",label:A.options.couponsOnly},{value:"virtual_only",label:A.options.virtualCouponsOnly}];return React.createElement(React.Fragment,null,React.createElement(wp.blockEditor.BlockControls,null,React.createElement(wp.components.ToolbarGroup,{controls:[{icon:"edit",title:"Edit",onClick:()=>s(!a),isActive:a}]})),React.createElement(wp.blockEditor.InspectorControls,{key:"inspector"},React.createElement(wp.components.PanelBody,{title:I.title,initialOpen:!0},React.createElement(o,{settings:t.contentVisibility,onChange:e=>l({contentVisibility:e})}))),a?React.createElement(wp.components.Placeholder,{label:F.title,className:"acfw-block-coupons-grid acfw-block-coupons-customer "+(P?"":"acfw-disabled-upsell")},React.createElement("div",{className:"description fullwidth-field"},F.description),React.createElement("div",{className:"display-type__selection one-half-col"},React.createElement(wp.components.SelectControl,{label:A.label,value:t.display_type,options:i,onChange:e=>l({display_type:e})})),React.createElement("div",{className:"order-by__selection one-half-col"},React.createElement(wp.components.SelectControl,{label:D.label,value:t.order_by,options:b,onChange:e=>l({order_by:e})})),React.createElement("div",{className:"items-count__range one-third-col"},React.createElement(wp.components.RangeControl,{label:V,value:t.count,onChange:e=>{const t=window.lodash.clamp(e,u,w);l({count:t})},min:u,max:w})),React.createElement("div",{className:"column-count__range one-third-col"},React.createElement(wp.components.RangeControl,{label:L,value:t.columns,onChange:e=>{const t=window.lodash.clamp(e,d,m);l({columns:t})},min:d,max:m})),React.createElement("div",{className:"block-actions fullwidth-field"},React.createElement(wp.components.Button,{isPrimary:!0,onClick:()=>{""===t.display_type&&l({display_type:"both"}),s(!1)}},O)),!P&&React.createElement("div",{className:"acfw-upsell-message",dangerouslySetInnerHTML:{__html:M}})):React.createElement(wp.serverSideRender,{block:c,attributes:t,EmptyResponsePlaceholder:()=>React.createElement(wp.components.Placeholder,{label:F.title,className:"acfw-block-coupons-grid acfw-block-coupons-customer"},F.emptyDesc,!P&&React.createElement("div",{className:"acfw-upsell-message",dangerouslySetInnerHTML:{__html:M}}))}))})),{couponsCustomerTexts:G}=acfwfBlocksi18n,$={name:"acfw/coupons-customer",settings:{title:G.title,icon:"tickets-alt",category:"advancedcoupons",keywords:["coupon","advanced","customer","user"],decription:G.title,supports:{align:["wide","full"],html:!1},example:{attributes:{isPreview:!0}},attributes:{display_type:{type:"string",default:""},...g,...f},edit:e=>React.createElement(z,{...e}),save:()=>null}},H=e=>{if(!e)return;const{name:t,settings:o}=e;wp.blocks.registerBlockType(t,o)};wp.domReady((()=>{[k,B,$].forEach(H)}))}}}));
