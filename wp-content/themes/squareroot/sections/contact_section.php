<?php 
global $squareroot_data;

?>
<?php if( $squareroot_data['rnr_enable_googlemap']) { ?>   
    <div class="close-footer"><i class="fa fa-map-marker"></i></div>  
        <div class="footer-contact">
            <div class="footer-content">
                <div class="footer-active" id="close-footer">
                    <div class="container">
                        <div class="contact-details">
                            <h2><?php echo $squareroot_data['rnr_contact_email'];  ?></h2>
                            <h1><?php echo $squareroot_data['rnr_contact_phone'];  ?></h1>
                            <h2><?php echo $squareroot_data['rnr_contact_address'];  ?></h2>
                        </div>
                    </div>
                </div>  
            </div> 
            <div class="my-contact-map">
            <div class="row contact-map">
					  <script type="text/javascript">
                        jQuery(document).ready(function() {
                      function initialize() {
                              var secheltLoc = new google.maps.LatLng(<?php echo $squareroot_data['rnr_map_lat']; ?>,<?php echo $squareroot_data['rnr_map_lon']; ?>);
                              var myMapOptions = {
                                   center: secheltLoc
                                  ,mapTypeId: google.maps.MapTypeId.ROADMAP
                                  ,zoom: <?php echo $squareroot_data['rnr_map_zoom']; ?> , scrollwheel: false,mapTypeControl: false, draggable: false
                              };
                              var theMap = new google.maps.Map(document.getElementById("google-map"), myMapOptions);
                              var image = new google.maps.MarkerImage(
                                  '<?php echo get_template_directory_uri().'/images/pinMap.png'; ?>',
                                  new google.maps.Size(17,26),
                                  new google.maps.Point(0,0),
                                  new google.maps.Point(8,26)
                              );
                              var shadow = new google.maps.MarkerImage(
                                  '<?php echo get_template_directory_uri().'/images/pinMap-shadow.png'; ?>',
                                  new google.maps.Size(33,26),
                                  new google.maps.Point(0,0),
                                  new google.maps.Point(9,26)
                              );
                              var marker = new google.maps.Marker({
                                  map: theMap,
                                  icon: image,
                                  shadow: shadow,
                                  draggable: false,
                                  animation: google.maps.Animation.DROP,
                                  position: secheltLoc,
                                  visible: true
                              });
                      
                              var boxText = document.createElement("div");
                              <?php if ($squareroot_data['rnr_map_logo']) {
                              ?>
                                boxText.innerHTML = '<div class="captionMap animated bounceInDown" style="text-align: center;"><img src="<?php echo $squareroot_data['rnr_map_logo']; ?>" class="alignleft"  alt="Contact Address"> <span style="padding-top: 9px;"><?php echo $squareroot_data['rnr_contact_address']; ?></span></div>';
                              <?php
                              }else { ?>
                                boxText.innerHTML = '<div class="captionMap animated bounceInDown" style="text-align: center;"> <span><?php echo $squareroot_data['rnr_contact_address']; ?></span></div>';
                              <?php 
                              }
                              ?>
                              var myOptions = {
                                   content: boxText
                                  ,disableAutoPan: false,maxWidth: 0
                                  ,pixelOffset: new google.maps.Size(-140, 0)
                                  ,zIndex: null
                                  ,boxStyle: { 
                                      width: "280px"
                                   }
                                  ,closeBoxURL: ""
                                  ,infoBoxClearance: new google.maps.Size(1, 1)
                                  ,isHidden: false
                                  ,pane: "floatPane"
                                  ,enableEventPropagation: false
                              };
                      
                              google.maps.event.addListener(theMap, "click", function (e) {
                                  ib.open(theMap, this);
                              });
                      
                              var ib = new InfoBox(myOptions);
                              ib.open(theMap, marker);
                              }
                              google.maps.event.addDomListener(window, 'load', initialize);
                              
                          });	
                          </script>   
                      <div id="google-map" class="embed clearfix">
                        <div class="mapPreLoading">
                            <span><h4>Loading</h4></span>
                            <span class="l-1"></span>
                            <span class="l-2"></span>
                            <span class="l-3"></span>
                            <span class="l-4"></span>
                            <span class="l-5"></span>
                            <span class="l-6"></span>
                        </div>
                      </div>
            </div>
            </div>  
        </div>
             <?php } ?> 