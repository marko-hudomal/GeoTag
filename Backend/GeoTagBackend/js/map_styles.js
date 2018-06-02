  var mark = null;

 
  function refresh()
  {
    myMap();
    google.maps.event.trigger(map, 'resize');
  }
      function myMap() {
        // Create a new StyledMapType object, passing it an array of styles,
        // and the name to be displayed on the map type control.
          var type=0;
          if(document.getElementById("map_style_form") && document.map_style_form.r.value=="night")
          {
            type=1
          }

          if (type==0)
          {
            initMap_Dessert(44.80565688, 20.47632003);
          }
          else if(type==1)
          {
            initMap_Night(44.80565688, 20.47632003);
          }
      }

function initMap_Dessert(x,y) {

        // Create a new StyledMapType object, passing it an array of styles,
        // and the name to be displayed on the map type control.
        var styledMapType = new google.maps.StyledMapType(
            [
              {elementType: 'geometry', stylers: [{color: '#ebe3cd'}]},
              {elementType: 'labels.text.fill', stylers: [{color: '#523735'}]},
              {elementType: 'labels.text.stroke', stylers: [{color: '#f5f1e6'}]},
              {
                featureType: 'administrative',
                elementType: 'geometry.stroke',
                stylers: [{color: '#c9b2a6'}]
              },
              {
                featureType: 'administrative.land_parcel',
                elementType: 'geometry.stroke',
                stylers: [{color: '#dcd2be'}]
              },
              {
                featureType: 'administrative.land_parcel',
                elementType: 'labels.text.fill',
                stylers: [{color: '#ae9e90'}]
              },
              {
                featureType: 'landscape.natural',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
              },
              {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
              },
              {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#93817c'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'geometry.fill',
                stylers: [{color: '#a5b076'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#447530'}]
              },
              {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#f5f1e6'}]
              },
              {
                featureType: 'road.arterial',
                elementType: 'geometry',
                stylers: [{color: '#fdfcf8'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#f8c967'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{color: '#e9bc62'}]
              },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry',
                stylers: [{color: '#e98d58'}]
              },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry.stroke',
                stylers: [{color: '#db8555'}]
              },
              {
                featureType: 'road.local',
                elementType: 'labels.text.fill',
                stylers: [{color: '#806b63'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.fill',
                stylers: [{color: '#8f7d77'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#ebe3cd'}]
              },
              {
                featureType: 'transit.station',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
              },
              {
                featureType: 'water',
                elementType: 'geometry.fill',
                stylers: [{color: '#b9d3c2'}]
              },
              {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#92998d'}]
              }
            ],
            {name: 'Styled Map'});
var bounds = new google.maps.LatLngBounds();
        // Create a map object, and include the MapTypeId to add
        // to the map type control.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: x, lng: y},
          zoom: 7,
          mapTypeControlOptions: {
            mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
                    'styled_map']
          }
        });

        //Associate the styled map with the MapTypeId and set it to display.
        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
                       icon = {
                                    //url: "https://image.flaticon.com/icons/svg/189/189097.svg",
                                    //url:"https://image.flaticon.com/icons/svg/727/727570.svg",
                                    url:"https://image.flaticon.com/icons/svg/526/526744.svg",
                                    scaledSize: new google.maps.Size(50,65), // scaled size
                        };
        var path = window.location.pathname;
        var page = path.split("/").pop();
        if (page == 'super_user_add_destination'){
            mark = new google.maps.Marker({
                position: {lat: x, lng: y},
                map: map,
                draggable: true,
                icon
            });
        }
	
		//var lat = homeMarker.getPosition().lat();
		//var lng = homeMarker.getPosition().lng();
        // Multiple Markers
	markers =[];
	var infoWindowContent = [];
        var controller = document.getElementById('pass_controller_type').innerHTML;
        
        
	for(var i=0;i<jArray.length;i++){
            var load_destination = controller + "/load_dest/" + jArray[i]['idDest'];
            load_destination = load_destination.replace(/\s/g, '');
            
            markers.push([jArray[i]['name']+", "+jArray[i]['country'],parseFloat(jArray[i]['latitude']),parseFloat(jArray[i]['longitude'])]);
	infoWindowContent.push(['<div class="info_content">' +
        '<h3><a href="'+load_destination+'">'+jArray[i]['name']+"</a>, "+jArray[i]['country']+'</h3>' +
           '</div>']);
        }
	
                        
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
        
    }
	
	
    
	
      }
function initMap_Night(x,y) {
        // Styles a map in night mode.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: x, lng: y},
          zoom: 7,
          styles: [
    {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#dfd2ae"
            }
        ]
    },
    {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#f5f1e6'}]
    },
    {
        "featureType": "poi",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "hue": "#1900ff"
            },
            {
                "color": "#c0e8e8"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [
            {
                "lightness": 100
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit.line",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "lightness": 700
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#b9d3c2"
            }
        ]
    }
]
        });
      }
	 function showCoordinate(){
		 document.getElementById("longitude").innerHTML= "Longitude: " + mark.getPosition().lng();
		 document.getElementById("latitude").innerHTML= "Latitude: " + mark.getPosition().lat();
		 document.getElementById("longitudeH").value= "Longitude: " + mark.getPosition().lng();
		 document.getElementById("latitudeH").value= "Latitude: " + mark.getPosition().lat();
	 }