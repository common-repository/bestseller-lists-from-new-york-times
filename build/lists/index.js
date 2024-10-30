!function(){"use strict";var e=window.wp.element,t=(window.wp.apiFetch,window.wp.components),l=window.wp.blockEditor,s=(0,e.createElement)("svg",{width:"24",height:"24",version:"1.1",viewBox:"0 0 1200 1200",xmlns:"http://www.w3.org/2000/svg"},(0,e.createElement)("path",{d:"m94.152 320.03 351.64-0.37109c2.207 37.02 2.9414 74.316 2.3867 111.71l387.83 1.5586c2.207-37.668 2.7461-75.504 0.91016-113.63l302.95-0.37109c9.7578 275.03-56.594 541.79 14.328 813.24l-1062.8 33.809c-28.473-281.74 33.254-566.69 2.75-845.94zm96.637 739.01 846.76-2.4727-7.3438-39.875-839.41 5.5195zm-12.121-81.203 845.48-19.836-9.7578-39.602-837.76 22.609zm-7.3555-95.242 846.59-7.9062-8.2695-39.77-839.04 10.836zm15.07-130.73 460.59 4.6797 3.1211-36.828-467.75-7.9922zm541.97 10.465 291.01-4.1406c-2.0273-66.312-2.5781-134.28 10.117-216.78l-298.01-0.082032c-11.941 72.109-11.387 145.96-3.1211 221zm-538.3-94.066 460.77-7.1641 1.6562-36.828-467.93 4.043zm-5.5078-99.016 460.57 10.02 3.875-36.66-467.75-13.5zm-161.86-534.53c383.98 20.207 573.2 1.0078 1084.7 43.906 15.805 62.555 24.996 124.48 29.578 185.83l-304.43-0.09375c-4.2344-36.098-10.836-72.383-20.578-109.22l-392.43-21.398c10.105 43.078 17.09 86.531 21.684 130.44l-354.39-0.27734c-12.121-76.977-32.34-153.41-64.117-229.19z"})),i=[{attributes:{initialList:{type:"string",default:"hardcover-fiction"}},save(){return null}}],n=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","name":"bestseller-lists-nyt/lists","title":"Bestseller Lists from NYT","description":"Show a widget to display all the bestseller lists from the New York Times","category":"embed","keywords":["books","new york times"],"apiVersion":2,"attributes":{"initialList":{"type":"string","default":"hardcover-fiction"},"displayImages":{"type":"boolean","default":true}},"editorScript":"file:./index.js","render":"file:./render.php"}');(0,window.wp.blocks.registerBlockType)(n.name,{...n,icon:s,edit:function(i){const n=(0,l.useBlockProps)({className:"nyt-bestseller-listings-booklist"}),{attributes:o,isSelected:r,setAttributes:a}=i,[c,m]=(0,e.useState)(null);(0,e.useEffect)((()=>{const e=ajaxurl+"?action=nyt_bestseller_listings_getAllLists";fetch(e).then((e=>e.json().then((e=>{m(e.data)}))))}),[]);const d=(0,e.useMemo)((()=>null===c?(0,e.createElement)(t.Spinner,null):c.length?(0,e.createElement)(t.SelectControl,{label:"Bestseller List",value:o.initialList,options:c,onChange:e=>a({initialList:e})}):(0,e.createElement)("p",{style:{color:"red"}},"Error: Unable to fetch lists")),[c,o.initialList]);return(0,e.createElement)("div",{...n},(0,e.createElement)(t.Placeholder,{icon:s,label:"Bestseller Lists from New York Times",instructions:"Choose which list displays initially"},d),(0,e.createElement)(l.InspectorControls,null,(0,e.createElement)(t.PanelBody,{title:"Settings"},(0,e.createElement)(t.PanelRow,null,(0,e.createElement)(t.ToggleControl,{label:"Display Book Cover Images",checked:o.displayImages,onChange:e=>a({displayImages:e})})))))},save:function(){return null},deprecated:i})}();