function material() {
  //console.log(selector.active);
  if (selector.as) {
    if (
      selector.as.split(":")[0] == "Navbar" ||
      selector.as.split(":")[0] == "Appbar"
    ) {
      //default
      type_nav = selector.as.split(":")[1];
      selector.children = {};
      selector.html = "";
      selector.text = "";
      selector.type = "nav";
      var type_navbar = {
        class: type_nav,
        children: {}
      };

      // for mobile i need this element in first !!
      // mobLinkList <object list>
      // mobTarget <string> !![important]
      // mobBtn <object list for element tree json> !![important]
      if (selector.mobLinkList) {
        list_links = {};
        for (i in selector.mobLinkList) {
          selector.mobLinkList[i].type = "a";
          brandLinkList_child = {};
          brandLinkList_child[i] = selector.mobLinkList[i];
          // for button active
          if (selector.mobLinkList[i].active == true) {
            brandLinkList_child_li_active = "active";
          } else brandLinkList_child_li_active = "";
          if (selector.mobLinkList[i].parentClass) {
            brandLinkList__li = selector.mobLinkList[i].parentClass;
          } else brandLinkList__li = "";

          list_links[i] = { type: "li", children: brandLinkList_child, class: brandLinkList_child_li_active + " " + brandLinkList__li };
        }
        if (!selector.mobBtn.attr) selector.mobBtn.attr = {};
        if (!selector.mobBtn.class) selector.mobBtn.class = "";
        if (!selector.mobBtn.init) selector.mobBtn.init = {};
        selector.mobBtn.init.onload = () => $(document).ready(() => $(".sidenav").sidenav())
         selector.mobBtn.class += "sidenav-trigger";
        selector.mobBtn.attr["data-target"] = selector.mobTarget;
        selector.mobBtn.type = "a";
        
        selector.children.mobBtn = selector.mobBtn;
        selector.children.brandLinkList = {
          type: "ul",
          class: 'sidenav',
          id: selector.mobTarget,
          children: list_links
        };
      }

      selector.children.type_nav = type_navbar;
      // brandLogo
      // => brandLogo => (<element[<String>return to html] | <String> >html)
      // => brandLogoHref => (<string>link)
      // => brandLogoAlign => (<string> (left - center - right))
      // => brandLogoId => (<string> (id name))
      // => brandLogoEvents (<list => object> {eventName : fn})
      if (selector.brandLogo) {
        if (selector.brandLogoAlign)
          brand_class = "brand-logo " + selector.brandLogoAlign;
        else brand_class = "brand-logo";
        if (selector.brandLogoId) {
          bland_logo_id = selector.brandLogoId;
        } else bland_logo_id = "";
        if (!selector.brandLogoHref) selector.brandLogoHref = "#";
        if (selector.brandLogoEvents)
          brand_events_list = selector.brandLogoEvents;
        else brand_events_list = {};
        selector.children.type_nav.children.brandLogo = {
          type: "a",
          class: brand_class,
          html: selector.brandLogo,
          attr: { href: selector.brandLogoHref },
          id: bland_logo_id,
          events: brand_events_list
        };
      }

      //brandLinkList
      // => {
      //  <list> hava
      // parentClass = <string>
      // active <bool> true | false !![to active a button]
      // }
      // brandLinkListAlign => (<string> (left <> right))
      // brandLinkListType => class<string>
      if (selector.brandLinkList) {
        if (selector.brandLinkListAlign) {
          brandLinkList_class_aling = selector.brandLinkListAlign;
        } else {
          brandLinkList_class_aling = "right";
        }
        if (selector.brandLinkListType) {
          brandLinkList_class_type = selector.brandLinkListType;
        } else brandLinkList_class_type = "hide-on-med-and-down";
        list_links = {};
        for (i in selector.brandLinkList) {
          selector.brandLinkList[i].type = "a";
          brandLinkList_child = {};
          brandLinkList_child[i] = selector.brandLinkList[i];
          // for button active
          if (selector.brandLinkList[i].active == true) {
            brandLinkList_child_li_active = "active";
          } else brandLinkList_child_li_active = "";
          if (selector.brandLinkList[i].parentClass) {
            brandLinkList__li = selector.brandLinkList[i].parentClass;
          } else brandLinkList__li = "";

          list_links[i] = {
            type: "li",
            children: brandLinkList_child,
            class: brandLinkList_child_li_active + " " + brandLinkList__li
          };
        }
        
        selector.children.type_nav.children.brandLinkList = {
          id: "nav-mobile",
          type: "ul",
          class: brandLinkList_class_aling + " " + brandLinkList_class_type,
          children: list_links
        };
      }
    } 
    // as (dropdown | dropdown:button) !![important]
      // => option(<list>) !![important]
      // => target => <string> // !![important]

    else if (selector.as.split(':')[0].replace(/ /gi, '') == "dropdown") {
      
      if (selector.as.split(":")[1] == "button") class_drapdown_type = "dropdown-trigger btn"; else class_drapdown_type = "dropdown-trigger" 
      //father_of_element;
      class_drapdown_d = (!selector.class) ? '' : selector.class
      selector.class = class_drapdown_type + class_drapdown_d;

      if (!selector.attr) selector.attr = {};
      

      selector.attr["data-target"] = selector.target;      
      
      if (selector.options) {
        for (i in selector.options) {
          selector.options[i].type = "li";
        }
      }
      ul_drapdown_option_ = {
        ul : {
          type :'ul',
          children: selector.options,
          id: selector.target,
          class: 'dropdown-content',
          init : {
            onload: () => $(".dropdown-trigger").dropdown()
          }

        }
      }
      
      if (!selector.init) selector.init = {};
      
      selector.init.onload = () => throw_alert(ul_drapdown_option_, father_of_element, true, undefined, undefined, undefined, global_setting);
      
      
    }
      // smallSceen => <int>!![req]
       // mediumSceen => <int>!![req]
        // largeSceen => <int>!![req]
         // extraSceen => <int>!![req]
         // screen => arr[s<int>,m , l, x ];
    else if (selector.as == "col") {
      if (!selector.class) selector.class = ""
      selector.class += " col";
      if (!selector.screen) {

        if (selector.smallSceen) selector.class  += " s" + selector.smallSceen;
        if (selector.mediumSceen) selector.class += " m" + selector.mediumSceen;
        if (selector.largeSceen) selector.class  += " l" + selector.largeSceen;
        if (selector.extraSceen) selector.class  += " x" + selector.extraSceen;

      } else {
        var screen_sizes = ['s', 'm', 'l', 'x'];
        var r_class = "";
        for (i in selector.screen) {
          r_class += ` ${screen_sizes[i]}${selector.screen[i]}`
        };
        selector.class += r_class;

      }

    
    } 
    
    else if (selector.as == "row") {
      if (!selector.class){
        selector.class = "row";
      }else {
        selector.class += " row";
      }

    } else if (selector.as == "container") {
      if (!selector.class) {
        selector.class = "container";
      } else {
        selector.class += " container";
      }
    } 
      // waves (bool<true | false>)
      // wavesColor <string> => light - dark
      // color <string> => btn bg color
      // size <string> large small
      // flat (bool<true | false>)
      //disabled (bool<true | false>)
      //pulse (bool<true | false>)
    else if (selector.as == "btn" || selector.as == "btn-floating") {
    
      selector.type = "button";
      if (!selector.class) selector.class = "";
      selector.class += " " + selector.as;
      if (selector.waves == true) {
        selector.class += " waves-effect";
      }
      if (selector.wavesColor) {
        selector.class += " waves-" + selector.wavesColor;
      }
      if (selector.color) {
        selector.class += " " +selector.color;
      }
      if (selector.size) {
        selector.class += " btn-" + selector.size;
      }
      if (selector.flat == true) {
        selector.class += " btn-flat";
      }
      if (selector.pulse == true) {
        selector.class +=" pulse";
      }
      if (selector.disabled == true) {
        selector.class += " disabled";
      }
    } 
      // collection
      // collectionItem <list>
    else if (selector.as == "collection") {
      if (!selector.class) selector.class = "";
      selector.class += " collection";
      console.log(selector);
      
      if (selector.collectionItem && typeof selector.collectionItem == "object") {

        if (!selector.children) selector.children = {};
        for (i in selector.collectionItem) {
          if (!selector.collectionItem[i].class) selector.collectionItem[i].class = "";
          selector.collectionItem[i].class += " collection-item";
        }
        
        selector.children = selector.collectionItem;
      }
    } // type (badge | new:badge) 
      // color <String>
    else if (selector.as == "badge" || selector.as == "new:badge") {
      if (!selector.class) selector.class = "";
      selector.type = "span";
      if (selector.color) selector.class += " " +selector.color;
      selector.class += (selector.as == "badge") ? ' badge' : ' new badge';

    } 
    // as tabs
    // has tabs => <list(object) : active ? true | false : screenSize as arrat [s, m, l, x]>
    else if (selector.as == "tabs") {
      if (!selector.class) selector.class = "";
      selector.class += "tabs";
      selector.type = "ul";
       if(!selector.init) selector.init = {};
      selector.init.onload = () =>  {
        $(document).ready(function () {
          $('.tabs').tabs();
        });
      };
      if (!selector.children) selector.children = {};

      if (selector.tabs) { 
        for (i in selector.tabs) {
          if (!selector.tabs[i].class) selector.tabs[i].class = "";
          //selector.tabs[i].class += "tab";
          
          selector.tabs[i].type = "a";
          if (selector.tabs[i].active == true) selector.tabs[i].class += 'active';
          var li = {
            type: 'li',
            class: 'tab',
            as: 'col',
            screen : selector.screenSize,
            children: {i : selector.tabs[i] },
          }
          selector.children[i] = li;
        }
        console.log(selector
          );

      }
    }
    // carouselItem => {list} //images
    else if (selector.as == "carousel") {
      if (!selector.class) selector.class = "";
      selector.class += " carousel";
      if (!selector.init) selector.init = {};
      selector.init.onload = () => {
        $(document).ready(function () {
          $('.carousel').carousel();
        });
      };
      if (selector.carouselItems) {
        for (i in selector.carouselItems) {
          var item = selector.carouselItems[i];
          item.type = "img";
          if (!item.parentClass) item.parentClass = ""
          var a = {
            type : 'a',
            class: 'carousel-item ' + item.parentClass,
            children: { i: item}
          }
          if (!selector.children) selector.children = {};
          selector.children[i] = a;

        }
      }
    }
    if (selector.depth) {
      if (!selector.class) selector.class = "";
      selector.class += ` z-depth-${selector.depth}`;
    }
    if (selector.flowText) {

      if (!selector.class) selector.class = "";
      selector.class += " flow-text";
    }

  }
}
icons = (name, style) => {
  r_style = "";
  for (i in style) {
    r_style = r_style + i + ":" + style[i] + ";";
  }
  el = document.createElement("i");
  el.style = r_style;
  el.innerHTML = name;
  el.className = "material-icons";
  return el.outerHTML;
};
