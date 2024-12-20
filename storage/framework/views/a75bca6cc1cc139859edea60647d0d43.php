
<?php $__env->startSection('title', __('Informe de Ubicación de DEAs')); ?>


<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card" >
                <div class="card" id="green-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Informe de Ubicación de DEA's</h5>
                    </div>
                    <div class="card-body form-card-body">
                        <div class="row">
                            <!--Insertar Mapa ARCGIS-->
                            <div id="viewDiv"></div>
                            <div
                              id="select-by-rectangle"
                              class="esri-widget esri-widget--button esri-widget esri-interactive"
                              title="Select features by rectangle"
                            >
                              <span class="esri-icon-checkbox-unchecked"></span>
                            </div>
                            <div
                              id="clear-selection"
                              class="esri-widget esri-widget--button esri-widget esri-interactive"
                              title="Clear selection"
                            >
                              <span class="esri-icon-erase"></span>
                            </div>
                            <div class="container">
                              <div id="tableDiv"></div>
                            </div>
                            <!--Fin Mapa ARCGIS-->
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="forms-footer">
    <div class="footer-bottom footer-mobile">
        <div class="footer_gov_">
           <div class="centradototal_ fooflex">
              <div class="logos_footer_gov"><a href="https://www.colombia.co" target="_blank"><img class="marcaco_l" src="../../images/logo.png" alt="colombia.co"></a></div>
              <div class="alcaldia_mod_footer"><a href="https://www.medellin.gov.co/es"><img  class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín"></a></div>
           </div>
        </div>
     </div>
</div>

<?php $__env->startPush('script'); ?>
<link rel="stylesheet" href="https://js.arcgis.com/4.28/esri/themes/light/main.css" />
<script src="https://js.arcgis.com/4.28/"></script>
<style>
  html,
  body {
    padding: 0;
    margin: 0;
    height: 100%;
    width: 100%;
  }

  #viewDiv {
    height: 50%;
    width: 100%;
  }

  .container {
    height: 50%;
    width: 100%;
  }
</style>
<script>
    require([
      "esri/Map",
      "esri/views/MapView",
      "esri/layers/CSVLayer",
      "esri/layers/FeatureLayer",
      "esri/layers/GraphicsLayer",
      "esri/widgets/Sketch/SketchViewModel",
      "esri/Graphic",
      "esri/widgets/FeatureTable",
      "esri/Basemap",
      "esri/geometry/geometryEngineAsync"
    ], function (
      Map,
      MapView,
      CSVLayer,
      FeatureLayer,
      GraphicsLayer,
      SketchViewModel,
      Graphic,
      FeatureTable,
      Basemap,
      geometryEngineAsync
    ) {
      // Use the states featurealayer as a basemap
      const states = new FeatureLayer({
        url: "https://sampleserver6.arcgisonline.com/arcgis/rest/services/USA/MapServer/2",
        renderer: {
          type: "simple",
          symbol: {
            type: "simple-fill",
            color: "#f0ebe4",
            outline: {
              color: "#DCDCDC",
              width: "0.5px"
            }
          }
        },
        spatialReference: {
          wkid: 102003
        },
        effect: "drop-shadow(-10px, 10px, 6px gray)"
      });

      // national parks csv layer
      const csvLayer = new CSVLayer({
        url: "https://ubatsukh.github.io/arcgis-js-api-demos/devsummit2021/csvLayer-nps/data/nps_establishments.csv",
        delimiter: ",",
        popupTemplate: {
          title: "{unit_name}",
          content: "Established on <b>{date_est}</b> <br/><br/> {description}"
        },
        renderer: setRenderer()
      });

      let csvLayerView;
      csvLayer
        .when(() => {
          view.whenLayerView(csvLayer).then(function (layerView) {
            csvLayerView = layerView;
          });
        })
        .catch(errorCallback);

      const map = new Map({
        basemap: new Basemap({
          baseLayers: [states]
        }),
        layers: [csvLayer]
      });

      // initialize the view with USA Contiguous Albers Equal Area Conic
      // projection and set the extent to the states
      const view = new MapView({
        container: "viewDiv",
        map: map,
        extent: {
          type: "extent",
          spatialReference: {
            wkid: 102003
          },
          xmax: 2275062,
          xmin: -2752064,
          ymax: 1676207,
          ymin: -1348080
        },
        constraints: {
          snapToZoom: false,
          minScale: 50465153
        },
        spatialReference: {
          wkid: 102003
        },
        background: {
          color: "white"
        }
      });

      // create a new instance of a FeatureTable
      const featureTable = new FeatureTable({
        view: view,
        layer: csvLayer,
        highlightOnRowSelectEnabled: false,
        fieldConfigs: [
          {
            name: "unit_name",
            label: "Name"
          },
          {
            name: "state",
            label: "State"
          },
          {
            name: "region",
            label: "Region"
          },
          {
            name: "unit_type",
            label: "Type"
          },
          {
            name: "created_by",
            label: "Created by"
          },
          {
            name: "date_est",
            label: "Established date"
          },
          {
            name: "description",
            label: "Description"
          },
          {
            name: "caption",
            label: "Caption"
          }
        ],
        container: document.getElementById("tableDiv")
      });

      // this array will keep track of selected feature objectIds to
      // sync the layerview feature effects and feature table selection
      let features = [];


      // Listen for the table's selection-change event
      featureTable.on("selection-change", (changes) => {
        // if the feature is unselected then remove the objectId
        // of the removed feature from the features array
        changes.removed.forEach((item) => {
          const data = features.find((data) => {
            return data === item.objectId;
          });
          if (data) {
            features.splice(features.indexOf(data), 1);
          }
        });

        // If the selection is added, push all added selections to array
        changes.added.forEach((item) => {
          features.push(item.objectId);
        });

        // set excluded effect on the features that are not selected in the table
        csvLayerView.featureEffect = {
          filter: {
            objectIds: features
          },
          excludedEffect: "blur(5px) grayscale(90%) opacity(40%)"
        };
      });


      // polygonGraphicsLayer will be used by the sketchviewmodel
      // show the polygon being drawn on the view
      const polygonGraphicsLayer = new GraphicsLayer();
      map.add(polygonGraphicsLayer);

      // add the select by rectangle button the view
      view.ui.add("select-by-rectangle", "top-left");
      const selectButton = document.getElementById("select-by-rectangle");


      // click event for the select by rectangle button
      selectButton.addEventListener("click", () => {
        view.closePopup();
        sketchViewModel.create("rectangle");
      });


      // add the clear selection button the view
      view.ui.add("clear-selection", "top-left");
      document.getElementById("clear-selection").addEventListener("click", () => {
        featureTable.highlightIds.removeAll();
        featureTable.filterGeometry = null;
        polygonGraphicsLayer.removeAll();
      });

      // create a new sketch view model set its layer
      const sketchViewModel = new SketchViewModel({
        view: view,
        layer: polygonGraphicsLayer
      });


      // Once user is done drawing a rectangle on the map
      // use the rectangle to select features on the map and table
      sketchViewModel.on("create", async (event) => {
        if (event.state === "complete") {
          // this polygon will be used to query features that intersect it
          const geometries = polygonGraphicsLayer.graphics.map(function (graphic) {
            return graphic.geometry;
          });
          const queryGeometry = await geometryEngineAsync.union(geometries.toArray());
          selectFeatures(queryGeometry);
        }
      });

      // This function is called when user completes drawing a rectangle
      // on the map. Use the rectangle to select features in the layer and table
      function selectFeatures(geometry) {
        if (csvLayerView) {
          // create a query and set its geometry parameter to the
          // rectangle that was drawn on the view
          const query = {
            geometry: geometry,
            outFields: ["*"]
          };

          // query graphics from the csv layer view. Geometry set for the query
          // can be polygon for point features and only intersecting geometries are returned
          csvLayerView
            .queryFeatures(query)
            .then((results) => {
              if (results.features.length === 0) {
                clearSelection();
              } else {
                // pass in the query results to the table by calling its selectRows method.
                // This will trigger FeatureTable's selection-change event
                // where we will be setting the feature effect on the csv layer view
                featureTable.filterGeometry = geometry;
                featureTable.selectRows(results.features);
              }
            })
            .catch(errorCallback);
        }
      }


      function errorCallback(error) {
        console.log("error happened:", error.message);
      }

      // this is called from CSVLayer constructor
      // tree CIM symbol
      function setRenderer() {
        return {
          type: "simple",
          symbol: {
            type: "cim",
            data: {
              type: "CIMSymbolReference",
              symbol: {
                type: "CIMPointSymbol",
                symbolLayers: [
                  {
                    type: "CIMVectorMarker",
                    enable: true,
                    anchorPointUnits: "Relative",
                    dominantSizeAxis3D: "Y",
                    size: 15.75,
                    billboardMode3D: "FaceNearPlane",
                    frame: {
                      xmin: 0,
                      ymin: 0,
                      xmax: 21,
                      ymax: 21
                    },
                    markerGraphics: [
                      {
                        type: "CIMMarkerGraphic",
                        geometry: {
                          rings: [
                            [
                              [15, 15],
                              [12, 15],
                              [16, 10],
                              [13, 10],
                              [17, 5],
                              [11, 5],
                              [11, 2],
                              [10, 2],
                              [10, 5],
                              [4, 5],
                              [8, 10],
                              [5, 10],
                              [9, 15],
                              [6, 15],
                              [10.5, 19],
                              [15, 15]
                            ]
                          ]
                        },
                        symbol: {
                          type: "CIMPolygonSymbol",
                          symbolLayers: [
                            {
                              type: "CIMSolidStroke",
                              enable: true,
                              capStyle: "Round",
                              joinStyle: "Round",
                              lineStyle3D: "Strip",
                              miterLimit: 10,
                              width: 0,
                              color: [0, 0, 0, 255]
                            },
                            {
                              type: "CIMSolidFill",
                              enable: true,
                              color: [0, 160, 0, 255]
                            }
                          ]
                        }
                      }
                    ],
                    scaleSymbolsProportionally: true,
                    respectFrame: true
                  },
                  {
                    type: "CIMVectorMarker",
                    enable: true,
                    colorLocked: true,
                    anchorPointUnits: "Relative",
                    dominantSizeAxis3D: "Y",
                    size: 8,
                    billboardMode3D: "FaceNearPlane",
                    frame: {
                      xmin: -5,
                      ymin: -5,
                      xmax: 5,
                      ymax: 5
                    },
                    markerGraphics: [
                      {
                        type: "CIMMarkerGraphic",
                        geometry: {
                          rings: [
                            [
                              [0, 5],
                              [0.87, 4.92],
                              [1.71, 4.7],
                              [2.5, 4.33],
                              [3.21, 3.83],
                              [3.83, 3.21],
                              [4.33, 2.5],
                              [4.7, 1.71],
                              [4.92, 0.87],
                              [5, 0],
                              [4.92, -0.87],
                              [4.7, -1.71],
                              [4.33, -2.5],
                              [3.83, -3.21],
                              [3.21, -3.83],
                              [2.5, -4.33],
                              [1.71, -4.7],
                              [0.87, -4.92],
                              [0, -5],
                              [-0.87, -4.92],
                              [-1.71, -4.7],
                              [-2.5, -4.33],
                              [-3.21, -3.83],
                              [-3.83, -3.21],
                              [-4.33, -2.5],
                              [-4.7, -1.71],
                              [-4.92, -0.87],
                              [-5, 0],
                              [-4.92, 0.87],
                              [-4.7, 1.71],
                              [-4.33, 2.5],
                              [-3.83, 3.21],
                              [-3.21, 3.83],
                              [-2.5, 4.33],
                              [-1.71, 4.7],
                              [-0.87, 4.92],
                              [0, 5]
                            ]
                          ]
                        },
                        symbol: {
                          type: "CIMPolygonSymbol",
                          symbolLayers: [
                            {
                              type: "CIMSolidStroke",
                              enable: true,
                              capStyle: "Round",
                              joinStyle: "Round",
                              lineStyle3D: "Strip",
                              miterLimit: 10,
                              width: 0.5,
                              color: [167, 169, 172, 255]
                            },
                            {
                              type: "CIMSolidFill",
                              enable: true,
                              color: [255, 255, 255, 255]
                            }
                          ]
                        }
                      }
                    ],
                    scaleSymbolsProportionally: true,
                    respectFrame: true
                  }
                ],
                haloSize: 1,
                scaleX: 1,
                angleAlignment: "Display"
              }
            }
          }
        };
      }
    });
  </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/user-consultassm/informe-ubicaciondeas.blade.php ENDPATH**/ ?>