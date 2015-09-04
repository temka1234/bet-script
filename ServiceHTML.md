Insert at bottom of your page HTML code:
```
<script src="BETSCRIPTLOCATION/?controller=servicehtml&action=view&view=View_Frontend_WidgetsLoader&raw=js" ></script> 
```
Before head tag add JS files for YUI js framework.
You can downloaded it or use hosted, we dont host or provide JS framework files.
```
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.5.0/build/cssreset/reset-min.css" />
        <script src="http://yui.yahooapis.com/3.5.0/build/yui-base/yui-base-min.js"></script>    
```

To call service add element with class name bs\_widget and id as url of called service:
```
<div id="View_Frontend_Widgets_OfferTableEvents&amp;groups_id=95&amp;event_types_id=7" class="bs_widget"> </div></div>
```
This widget will call View\_Frontend\_Widgets\_OfferTableEvents view;

All widgets you can find under application/View