import{g as m,s as f,c as u,i as y,r as k,a as C}from"../../common/NoticesPlugin.4b31c3cc.js";/* empty css                         */function j(){import.meta.url,import("_").catch(()=>1);async function*t(){}}function S(){const{OrderSummarySubtotalBlock:t}=acfwfObj.components,{store_credits:c}=m(u.integration),{pay_with_store_credits_text:o}=c,{acfwf_block:e}=f.getCartData().extensions;if(e&&e.store_credits&&e.store_credits.amount){const{amount_text:r}=e.store_credits;return React.createElement(t,{label:o,value:r})}return null}const N=t=>{const{adminAjaxUrl:c}=acfwfObj,{dummyUpdateCart:o}=acfwfObj.wc,{setButtonDisabled:e,amount:r,setAmount:a,redeem_nonce:n}=t,{dispatch:s}=wp.data;e(!0),jQuery.post(c,{action:"acfwf_redeem_store_credits",amount:r,wpnonce:n,is_cart_checkout_block:!0},function(l){o(),a(""),s("core/notices").createNotice(l.status,l.message,{type:"snackbar",context:"wc/checkout"}),setTimeout(()=>{e(!1)},200)})};function v(){const{Accordion:t}=acfwfObj.components,{useState:c}=wp.element,{caret_img_src:o,store_credits:e}=m(u.integration),{button_text:r,redeem_nonce:a,hide_store_credits_on_zero_balance:n,auto_display_store_credits_redeem_form:s}=e,{balance_text:l,instructions:p,placeholder:w}=e.labels,{toggle_text:b}=e.labels,[d,_]=c(""),[g,E]=c(!1),{acfwf_block:i}=f.getCartData().extensions;if(!i||!i.store_credits)return null;const{balance:R,balance_text:h}=i.store_credits;return!R&&n==="yes"?null:React.createElement("div",{className:"acfwf-components acfw-checkout-ui-block"},React.createElement(t,{title:b,caret_img_src:o,auto_display_store_credits_redeem_form:s},React.createElement("div",null,React.createElement("p",{className:"acfw-store-credit-user-balance"},React.createElement("div",{dangerouslySetInnerHTML:{__html:l.replace("%s","<strong>".concat(h,"</strong>"))}})),React.createElement("p",{className:"acfw-store-credit-instructions"},p),React.createElement("div",{id:"acfw_redeem_store_credit",className:"acfw-redeem-store-credit-form-field acfw-checkout-form-button-field "},React.createElement("p",{className:"form-row form-row-first acfw-form-control-wrapper acfw-col-left-half wfacp-input-form"},React.createElement("label",{htmlFor:"coupon_code"}),React.createElement("input",{type:"text",className:"input-text wc_input_price ",value:d,placeholder:w,onChange:x=>{_(x.target.value)}})),React.createElement("p",{className:"form-row form-row-last acfw-col-left-half acfw_coupon_btn_wrap"},React.createElement("label",{className:"acfw-form-control-label"}),React.createElement("button",{type:"button",className:"button alt",onClick:()=>N({setButtonDisabled:E,amount:d,setAmount:_,redeem_nonce:a}),disabled:g},r))))))}function D(){const{ExperimentalDiscountsMeta:t,ExperimentalOrderMeta:c}=wc.blocksCheckout,{registerPlugin:o}=wp.plugins,{store_credits:e}=m(u.integration),{apply_type:r,display_store_credits_redeem_form:a,store_credits_module:n,is_allow_store_credits:s}=e;n&&a==="yes"&&s&&(o("acfw-store-credit-discount-form",{render:()=>React.createElement(c,null,React.createElement(v,null)),scope:"woocommerce-checkout"}),r!=="coupon"&&o("acfw-store-credit-discount-row",{render:()=>React.createElement(t,null,React.createElement(S,null)),scope:"woocommerce-checkout"}))}y();k();C();D();export{j as __vite_legacy_guard};
