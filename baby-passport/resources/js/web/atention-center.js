const countries = [
    {
        country: "México",
        color: "mandys-pink",
        locations: [
           /* {
                description: "San Miguel de Allende",
                doctor: "Dr.Roberto Maxwell",
                latitude: 20.9142,
                longitude: -100.744,
                rating: 4,
                video:"https://player.vimeo.com/video/395817159"
              
            },*/

            {
                description: "CDMX",
                doctor: "Dr.Armesto Alfonso",
                latitude: 19.6991206,
                longitude: -99.0880683,
                rating: 5,
                speciality: "Socio del programa Baby Passport",
                video:"https://player.vimeo.com/video/395817159",
                url:"https://medicaltourismmx.com/"
               
            },
            {
                description: "Querétaro",
                doctor: "Dr.Guillermo Camacho Pérez",
                latitude: 20.842512,
                longitude: -99.819808,
                rating: 3,
                speciality: "Perinatología, ginecología y obstetricia",
                video:"https://player.vimeo.com/video/391549672?loop=1",
                url:"https://perinatologoenqro.com/"
                
            }
        ]
    }
];

$.renderMap = function() {
    const urlBase = $("#DATA").data("url");

    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 6,
        center: new google.maps.LatLng(21.121914, -101.666011),
        mapTypeId: "roadmap",
        styles: [
            {
                elementType: "geometry",
                stylers: [
                    {
                        color: "#eaeaea"
                    }
                ]
            },
            {
                elementType: "labels",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                elementType: "labels.icon",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#616161"
                    }
                ]
            },
            {
                elementType: "labels.text.stroke",
                stylers: [
                    {
                        color: "#f5f5f5"
                    }
                ]
            },
            {
                featureType: "administrative",
                elementType: "geometry",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                featureType: "administrative.land_parcel",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                featureType: "administrative.land_parcel",
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#bdbdbd"
                    }
                ]
            },
            {
                featureType: "administrative.neighborhood",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                featureType: "poi",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                featureType: "poi",
                elementType: "geometry",
                stylers: [
                    {
                        color: "#eeeeee"
                    }
                ]
            },
            {
                featureType: "poi",
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#757575"
                    }
                ]
            },
            {
                featureType: "poi.park",
                elementType: "geometry",
                stylers: [
                    {
                        color: "#e5e5e5"
                    }
                ]
            },
            {
                featureType: "poi.park",
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#9e9e9e"
                    }
                ]
            },
            {
                featureType: "road",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                featureType: "road",
                elementType: "geometry",
                stylers: [
                    {
                        color: "#ffffff"
                    }
                ]
            },
            {
                featureType: "road",
                elementType: "labels.icon",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                featureType: "road.arterial",
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#757575"
                    }
                ]
            },
            {
                featureType: "road.highway",
                elementType: "geometry",
                stylers: [
                    {
                        color: "#dadada"
                    }
                ]
            },
            {
                featureType: "road.highway",
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#616161"
                    }
                ]
            },
            {
                featureType: "road.local",
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#9e9e9e"
                    }
                ]
            },
            {
                featureType: "transit",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                featureType: "transit.line",
                elementType: "geometry",
                stylers: [
                    {
                        color: "#e5e5e5"
                    }
                ]
            },
            {
                featureType: "transit.station",
                elementType: "geometry",
                stylers: [
                    {
                        color: "#eeeeee"
                    }
                ]
            },
            {
                featureType: "water",
                elementType: "geometry",
                stylers: [
                    {
                        color: "#ffffff"
                    }
                ]
            },
            {
                featureType: "water",
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#ffffff"
                    }
                ]
            }
        ]
    });

    map.data.loadGeoJson(urlBase + "/geojson/usa.json");
    map.data.loadGeoJson(urlBase + "/geojson/mexico.json");
    map.data.loadGeoJson(urlBase + "/geojson/colombia.json");

    map.data.setStyle(function(feature) {
        const country = feature.l.sov_a3;

        console.log(country);
        switch (country) {
            case "MEX":
                return {
                    fillColor: "#f3be9a",
                    strokeWeight: 2,
                    strokeColor: "#f3be9a"
                };
                break;

            case "US1":
                return {
                    fillColor: "#9a7aa0",
                    strokeWeight: 2,
                    strokeColor: "#9a7aa0"
                };
                break;

            case "COL":
                return {
                    fillColor: "#78ded4",
                    strokeWeight: 2,
                    strokeColor: "#78ded4"
                };
                break;
        }
    });

    const icons = {
        blue: {
            icon: urlBase + "/img/miscellaneous/fav.png"
        }
    };

    var markers = [];
    var markers_caption = [];

    $.each(countries, function(key, val) {
        const country = val.country;

        $.each(val.locations, function(key, val) {
            //inline template
            const contentString = `
            <div class="row px-0 py-0">
            <div class="col-12">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src= ${val.video} frameborder="0"
                            class="embed-responsive-item"
                           ></iframe>                           
                </div>
            </div>
        </div>
                <div>
                     <a href="${val.url}"class="info-content text-grey-suit lead">
                    <h3 class="info-heading text-grey-suit pt-3">${val.doctor}</h3>
                    </a>  
                    <p class="info-content text-grey-suit lead">
                    ${val.description}
                    </p>
                    <p class="info-content text-grey-suit lead">
                    ${val.speciality}
                    </p>   
                    <p class="card-text mb-1 pt-2">
                    <i class="fas fa-star text-spray"></i> <i class="fas fa-star text-spray"></i> <i class="fas fa-star text-spray"></i> <i class="fas fa-star text-spray"></i> <i class="fas fa-star text-spray"></i>
                    </p>
                </div>
                <button type="submit" id="maps-doctor" value="${val.doctor}" class="btn btn-maps-doctor button-border btn-ce-soir btn-lg white-text my-3 ml-0" onclick="mapDoctor()" >
                <i class="fas fa-calendar mr-2"></i> Agendar
               </button>
            `;
         
            markers_caption.push(
                new google.maps.InfoWindow({
                    content: contentString
                })
            );

            markers.push({
                position: new google.maps.LatLng(val.latitude, val.longitude),
                type: "blue"
            });
        });

        
    });


    

//Whatsapp-data-maps-doctor
$(".btn-maps-doctor,[data-whats]").on("click", function () {
    
    var nameDoctor = document.getElementById("maps-doctor").value
           text = `*Quiero información sobre el doctor* ${nameDoctor} %0a`;
            window.open(
                "https://api.whatsapp.com/send?phone=524425542704" + "&text=" + text
            );

            return false;
        });

    markers.forEach(function(marker, index) {
        var marker = new google.maps.Marker({
            position: marker.position,
            icon: icons[marker.type].icon,
            map: map,
            title: "Ejemplo"
        });

        marker.addListener("click", function(map) {
            markers_caption[index].open(map, marker);
        });
    });

    google.maps.event.addListener(map, "click", function(event) {
        console.log(event.latLng);
    });
};

$(function() {
    var htmlCountries = "";

    $.each(countries, function(key, val) {
        htmlCountries += `
        <h2 class="h2-responsive mt-5 text-${val.color}">
            ${val.country} 
            <span class="badge badge-${val.color} float-right clearfix">${val.locations.length}</span>
        </h2>
`;

        var locationsHtml = '<ul class="list-group list-group-flush mt-3">';
        $.each(val.locations, function(key, val) {
            locationsHtml += `
            <li class="list-group-item lead text-grey-suit">
                ${val.description}
            </li>
            `;
        });

        locationsHtml += "</ul>";
        htmlCountries += locationsHtml;

        $(".mapIndex").html(htmlCountries);
    });
});

$(function() {
    $("#select").on("change", function() {
        window.location.href = $(this).val();
    });
});



