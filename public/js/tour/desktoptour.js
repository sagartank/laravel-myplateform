var device_type_tour = detectDeviceTypeTour();

if(device_type_tour == 'dst') {
    $('#tutorial').click(function (e) {
        e.preventDefault();
        var _val = $('#select_preferred_dashboard').val();
        if (_val == 'Investor') {
            tour_2.hide();
            tour.show();
            tour.start();
            tourInvestor();
        } else if (_val == 'Borrower') {
            tour.hide();
            tour_2.show();
            tour_2.start();
            tourBorrower();
        }

        if(route_name == 'explore-operations.index') {
            tourExplore.show();
            tourExplore.start();
            tourExploreOperation();
        } else if(route_name == 'operations.index') {
            tourOperation.show();
            tourOperation.start();
            tourMyOperation();
        }  else if(route_name == 'operations.create') {
            tourCreateOp.show();
            tourCreateOp.start();
            tourCreateOperation();
        }
    });

    const tour = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    const tour_2 = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    const tourExplore = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    const tourOperation = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    const tourCreateOp = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    function tourInvestor() {
        tour.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Hola, mi nombre es PACO y vengo a hacerte un tour para que aprendas a usar MIPO a la perfección. MIPO es una plataforma de compra/venta de documentos y muchas de sus funcionalidades pueden parecer complejas pero a medida que vayas usando te iras dando cuenta que no lo son. Aprieta continuar para seguir con el tour o cerrar para realizar mas adelante.</p>',
            attachTo: {
                element: '.header_wrap .head_left .logo',
                on: 'top'
            },
            highlightClass: '.logo',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_1'
        });
    
        tour.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Este es el menú principal donde podrás ver los tableros como vendedor y como inversor de operaciones en curso y cerradas, asi tambien las analiticas de las mismas.</p>`,
            attachTo: {
                element: '.tur_first',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_2'
        });
    
        tour.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí como inversor veras todos los documentos disponibles en el mercado en guaranies y en dolares, asi como todas las ofertas enviadas a vendedores.</p>`,
            attachTo: {
                element: '.tur_second',
                on: 'top'
            },
            highlightClass: 'high_tur_second',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_3'
        });
    
        tour.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>En Mis Operaciones vas a poder ver tus documentos cargados, las ofertas recibidas sobre tus documentos y tu perfil personal como lo ven terceros. Como vendedor, este es el tablero donde podrás manejar toda la información.</p>`,
            attachTo: {
                element: '.tur_third',
                on: 'top'
            },
            highlightClass: '.tur_third',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_4'
        });
    
        tour.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí se encuentran las operaciones que fueron concretadas, ya sea venta de documentos o compra de los mismos, y podrás hacer seguimiento del estado de cada uno, ver pasos pendientes para finalizar y ver información de la operación en sí.</p>`,
            attachTo: {
                element: '.tur_fourth',
                on: 'top'
            },
            highlightClass: '.tur_fourth',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_5'
        });
    
        tour.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Desde esta parte puedes cambiar modo de tablero de inversor a vendedor, filtrar periodos a mostrar en tableros y tipo de moneda a mostrar, ya sea Guaranies o Dolares Americanos.</p>`,
            attachTo: {
                element: '.buttons_wrap .btns_left',
                on: 'top'
            },
            highlightClass: '.btns_left',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_6'
        });
    
        tour.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí podrás visualizar las utilidades generadas sobre el total de inversiones realizadas y retorno sobre las mismas porcentualmente.</p>`,
            attachTo: {
                element: '.main_rev_section .rev_tur_first',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_7'
        });
    
        tour.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Desde aquí podrás hacer seguimiento rápido de inversiones en curso pendientes de aceptación o con contraofertas pendientes. En síntesis, tu posición en juego en caso de que te acepten todas las ofertas que enviaste.</p>`,
            attachTo: {
                element: '.main_rev_section .rev_tur_second',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_8'
        });
    
        tour.addStep({
            title: 'Paco',
            text: `${paco_img_tag}<p>En caso de haber adquirido el documento con servicio de MIPO+, garantizándose el recupero de inversión, podra visualizar aqui documentos comprados normalmente vs los que tienen recompra garantizada de nuestra parte. Al ingresar podra ver como esta dividida su cartera de inversión.</p>`,
            attachTo: {
                element: '.main_rev_section .rev_tur_third',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_9'
        });
    
        tour.addStep({
            title: 'Paco',
            text: `${paco_img_tag}<p>En caso de contar con usuarios dentro de su cuenta, podrá hacer un seguimiento de las operaciones de as que están formando parte, evaluando el rendimiento de cada uno de forma rápida.</p>`,
            attachTo: {
                element: '.sub_user_row',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_10'
        });
    
        tour.addStep({
            title: 'Paco',
            text: `${paco_img_tag}<p>En esta parte inferior se encuentra información adicional sobre las operaciones con datos específicos para poder hacer seguimiento.</p>`,
            attachTo: {
                element: '.imp_data_row',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_11'
        });
    
        tour.addStep({
            title: 'Paco',
            text: `${paco_img_tag}<p>En caso de tener problemas con documentos comprados o vendidos, aquí podrá ver el resumen y hacerle seguimiento a la misma.</p>`,
            attachTo: {
                element: '.main_open_wrapper',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'investor_12'
        });
    
        tour.start();
    }
    
    function tourBorrower() {
        tour_2.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Al cambiar el tipo de usuario de Inversor a Vendedor, los tableros abajo contienen la información relevante a la venta de documentos.</p>`,
            attachTo: {
                element: '#sel_wrapfirst',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'borrower_1'
        });
        tour_2.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí se muestran el total de documentos vendidos sobre operaciones concretadas.</p>`,
            attachTo: {
                element: '.bor_tur_first',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'borrower_2'
        });
        tour_2.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Las ofertas recibidas vas a poder ver de forma rapida aqui con el valor mismo y el valor nominal de los documentos. Podrás ver detalle de ofertas recibidas.</p>`,
            attachTo: {
                element: '.bor_tur_second',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'borrower_3'
        });
        tour_2.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí podrás ver un resumen del total percibido sobre lo vendido en detalle.</p>`,
            attachTo: {
                element: '.bor_tur_third',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'borrower_4'
        });
    
        tour_2.start();
    
    }
    
    function tourExploreOperation() {
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Bienvenido al Mercado de Operaciones, aqui podras encontrar todos los documentos cargados en la plataforma, y ofertar por los mismos el valor que consideres oportuno!</p>',
            attachTo: {
                element: '.eo_dtl',
                on: 'top'
            },
            highlightClass: '.eo_dtl',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_1'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Este apartado es de filtros, con el mismo podrás afinar tu búsqueda hasta encontrar documentos específicos que se adapten a tu necesidad.</p>',
            attachTo: {
                element: '.advance_filter',
                on: 'top'
            },
            highlightClass: '.advance_filter',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_2'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Este apartado es de filtros, con el mismo podrás afinar tu búsqueda hasta encontrar documentos específicos que se adapten a tu necesidad.</p>',
            attachTo: {
                element: '.offer_wrap',
                on: 'top'
            },
            highlightClass: '.offer_wrap',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_3'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Esta es una operación, en la misma podrás ver datos del vendedor, pagador, vencimientos y datos adicionales, podes hacer click en cualquiera de las partes para entrar a perfiles o a la operación en si, para ver mas información y adjuntos de los documentos.</p>',
            attachTo: {
                element: '.com_tour',
                on: 'top'
            },
            highlightClass: '.com_tour',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_4'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Si estas convencido de las operaciones que te figuran en el mercado y queres ofertar por una o por varias, podes seleccionar las mismas y apretar ofertar.</p>',
            attachTo: {
                element: '.operatorbox_outer',
                on: 'top'
            },
            highlightClass: '.operatorbox_outer',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_5'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Luego de seleccionada la operación, haz click aqui para ver resumen de tu oferta, con utilidad neta, asi como tambien posibilidad de realizar ofertas grupales, agrupando las mismas por vendedor y por tipo.</p>',
            attachTo: {
                element: '.expireDay',
                on: 'top'
            },
            highlightClass: '.expireDay',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    var total_offers = $(".explore_operation_ids:checked").length;
                    if(total_offers > 0 ) {
                        $('.btn_group_offer').trigger('click');
                        setTimeout(() => {
                            console.log('111', total_offers);
                            return this.next();
                        }, 1000);
                    } else {
                        $('#chk_all_explore').trigger('click');
                        var total_offers = $(".explore_operation_ids:checked").length;
                        if(total_offers > 0 ) {
                            $('.btn_group_offer').trigger('click');
                            setTimeout(() => {
                                console.log('222', total_offers);
                                // tourExplore.show('explore_operation_7');
                                return this.next();
                            }, 1000);
                        } else {
                            toastr.error(please_sel_explore_op_en_msg);
                            tourExplore.complete();
                        }
                    }
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_6'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Al ofertar las operaciones se separan por tipo de moneda, dólares americanos y guaraníes.</p>',
            attachTo: {
                element: '#myTab',
                on: 'top'
            },
            highlightClass: '#myTab',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_7'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Al seleccionar varias operaciones y apretar ofertar, se abre esta pantalla y separan por tipo de documento y vendedor. Se puede escribir oferta de forma independiente o se puede clickear en la ultima linea a la izquierda el checkbox para hacer una oferta grupal por todos los documentos contenidos en la sección.</p>',
            attachTo: {
                element: '.offerboxlink:first-child',
                on: 'top'
            },
            highlightClass: '.offerboxlink:first-child',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_8'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Al ir cargando los campos con los montos de las ofertas, se comenzaran a llenar campos a continuación, a la izquierda es el resumen de la operación sobre la que uno esta escribiendo y a la derecha esta el resumen global de todas las operaciones que tienen valor escrito. De esta forma podrá sacar de forma rápida un estimado de beneficio en cada operación que desee adquirir.</p>',
            attachTo: {
                element: '.grp_oprt_summary',
                on: 'top'
            },
            highlightClass: '.grp_oprt_summary',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    tourExplore.complete();
                    // return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_9'
        });

       /*  tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Al seleccionar varias operaciones y apretar ofertar, se abre esta pantalla y separan por tipo de documento y vendedor. Se puede escribir oferta de forma independiente o se puede clickear en la ultima linea a la izquierda el checkbox para hacer una oferta grupal por todos los documentos contenidos en la sección.</p>',
            attachTo: {
                element: '.offerboxlink',
                on: 'top'
            },
            highlightClass: '.offerboxlink',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    tourExplore.complete();
                    // return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_10'
        });
        tourExplore.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Al ir cargando los campos con los montos de las ofertas, se comenzaran a llenar campos a continuación, a la izquierda es el resumen de la operación sobre la que uno esta escribiendo y a la derecha esta el resumen global de todas las operaciones que tienen valor escrito. De esta forma podrá sacar de forma rápida un estimado de beneficio en cada operación que desee adquirir.</p>',
            attachTo: {
                element: '.grp_oprt_summary',
                on: 'top'
            },
            highlightClass: '.grp_oprt_summary',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    tourExplore.complete();
                    // return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'explore_operation_11'
        }); */
    
        tourExplore.start();
    
    }
    
    function tourMyOperation() {
        tourOperation.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Bienvenido a Mis Operaciones, aqui encontraras las ofertas recibidas por inversores, las operaciones cargadas para venta con su actual estado (aprobación/rechazo) y Tu Perfil, que resume tu posición en la plataforma, siendo lo que terceros pueden visualizar públicamente.</p>',
            attachTo: {
                element: '.my_operations_left',
                on: 'top'
            },
            highlightClass: '.my_operations_left',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'my_operation_1'
        });
        tourOperation.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Al hacer Click en la Operación particular, se abre el campo de ofertas donde puede visualizarse una a una las ofertas recibidas, al hacer click en alguna, se abre el campo de Aceptación/Rechazo/Contraoferta que permite buscar mejorar las ofertas, aceptar en caso de estar satisfecho o rechazar en caso de definitivamente considerar muy por debajo de lo esperado. También figura el historial de ofertas asi como tiempo para expiración de la misma por parte del inversor.</p>',
            attachTo: {
                element: '.counteroffer',
                on: 'top'
            },
            highlightClass: '.counteroffer',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'my_operation_2'
        });
    
        tourOperation.start();
    
    }
    
    function tourCreateOperation() {
        tourCreateOp.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Bienvenido a Mis Operaciones, aqui encontraras las ofertas recibidas por inversores, las operaciones cargadas para venta con su actual estado (aprobacion/rechazo) y Tu Perfil, que resume tu posición en la plataforma, siendo lo que terceros pueden visualizar publicamente.</p>',
            attachTo: {
                element: '.page_heading',
                on: 'top'
            },
            highlightClass: '.page_heading',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'create_operation_1'
        });
    
        tourCreateOp.start();
    }
} else {
    $('#tutorial').click(function (e) {
        e.preventDefault();
        var _val = $('#select_preferred_dashboard').val();
        if (_val == 'Investor') {
            mobile_tour_seller.hide();
            mobile_tour_buyer.show();
            mobile_tour_buyer.start();
            tourInvestorMobile();
        } else if (_val == 'Borrower') {
            mobile_tour_buyer.hide();
            mobile_tour_seller.show();
            mobile_tour_seller.start();
            tourBorrowerMobile();
        }
    
        if(route_name == 'explore-operations.index') {
            mobile_tour_explore.show();
            mobile_tour_explore.start();
            tourExploreOperationMobile();
        } else if(route_name == 'operations.index') {
            mobile_tour_operation.show();
            mobile_tour_operation.start();
            tourOperationMobile();
        }  else if(route_name == 'operations.create') {
            mobile_tour_create_op.show();
            mobile_tour_create_op.start();
            tourCreateOperationMobile();
        }
    });

    // mobile
    const mobile_tour_buyer = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    const mobile_tour_seller = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    const mobile_tour_explore = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    const mobile_tour_operation = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });
    
    const mobile_tour_create_op = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: true
            },
            classes: 'shadow-lg bg-purple-dark m-2',
            scrollTo: {
                behavior: 'smooth',
                block: 'center'
            }
        },
        useModalOverlay: true,
    });

    function tourInvestorMobile() {
        mobile_tour_buyer.addStep({
            title: `${paco_img_tag}`,
            text: '<h6>Paco</h6><p>Hola, mi nombre es PACO y vengo a hacerte un tour para que aprendas a usar MIPO a la perfección. MIPO es una plataforma de compra/venta de documentos y muchas de sus funcionalidades pueden parecer complejas pero a medida que vayas usando te iras dando cuenta que no lo son. Aprieta continuar para seguir con el tour o cerrar para realizar mas adelante.</p>',
            attachTo: {
                element: '.header_wrap .head_left .logo',
                on: 'top'
            },
            highlightClass: '.head_left',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_1'
        });
    
        mobile_tour_buyer.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Este es el menú principal donde podrás ver los tableros como vendedor y como inversor de operaciones en curso y cerradas, asi tambien las analiticas de las mismas.</p>`,
            attachTo: {
                element: '.mob_tur_first',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_2'
        });
    
        mobile_tour_buyer.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí como inversor veras todos los documentos disponibles en el mercado en guaranies y en dolares, asi como todas las ofertas enviadas a vendedores.</p>`,
            attachTo: {
                element: '.mob_tur_second',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_3'
        });
    
        mobile_tour_buyer.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>En Mis Operaciones vas a poder ver tus documentos cargados, las ofertas recibidas sobre tus documentos y tu perfil personal como lo ven terceros. Como vendedor, este es el tablero donde podrás manejar toda la información.</p>`,
            attachTo: {
                element: '.mob_tur_third',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_4'
        });
    
        mobile_tour_buyer.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí se encuentran las operaciones que fueron concretadas, ya sea venta de documentos o compra de los mismos, y podrás hacer seguimiento del estado de cada uno, ver pasos pendientes para finalizar y ver información de la operación en sí.</p>`,
            attachTo: {
                element: '.mob_tur_fourth',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_5'
        });
    
        mobile_tour_buyer.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Desde esta parte puedes cambiar modo de tablero de inversor a vendedor, filtrar periodos a mostrar en tableros y tipo de moneda a mostrar, ya sea Guaranies o Dolares Americanos.</p>`,
            attachTo: {
                element: '.buttons_wrap',
                on: 'top'
            },
            highlightClass: '.buttons_wrap',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_6'
        });
    
        mobile_tour_buyer.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí podrás visualizar las utilidades generadas sobre el total de inversiones realizadas y retorno sobre las mismas porcentualmente.</p>`,
            attachTo: {
                element: '.mobile_slider_section .mobile_rev_tur_first',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_7'
        });
    
        mobile_tour_buyer.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Desde aquí podrás hacer seguimiento rápido de inversiones en curso pendientes de aceptación o con contraofertas pendientes. En síntesis, tu posición en juego en caso de que te acepten todas las ofertas que enviaste.</p>`,
            attachTo: {
                element: '.mobile_slider_section .mobile_rev_tur_second',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_8'
        });
    
        mobile_tour_buyer.addStep({
            title: 'Paco',
            text: `${paco_img_tag}<p>En caso de haber adquirido el documento con servicio de MIPO+, garantizándose el recupero de inversión, podra visualizar aqui documentos comprados normalmente vs los que tienen recompra garantizada de nuestra parte. Al ingresar podra ver como esta dividida su cartera de inversión.</p>`,
            attachTo: {
                element: '.mobile_slider_section .mobile_rev_tur_third',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_9'
        });
    
        mobile_tour_buyer.addStep({
            title: 'Paco',
            text: `${paco_img_tag}<p>En caso de contar con usuarios dentro de su cuenta, podrá hacer un seguimiento de las operaciones de as que están formando parte, evaluando el rendimiento de cada uno de forma rápida.</p>`,
            attachTo: {
                element: '.sub_user_row',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_10'
        });
    
        mobile_tour_buyer.addStep({
            title: 'Paco',
            text: `${paco_img_tag}<p>En esta parte inferior se encuentra información adicional sobre las operaciones con datos específicos para poder hacer seguimiento.</p>`,
            attachTo: {
                element: '.imp_data_row',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_11'
        });
    
        mobile_tour_buyer.addStep({
            title: 'Paco',
            text: `${paco_img_tag}<p>En caso de tener problemas con documentos comprados o vendidos, aquí podrá ver el resumen y hacerle seguimiento a la misma.</p>`,
            attachTo: {
                element: '.main_open_wrapper',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_investor_12'
        });
    
        mobile_tour_buyer.start();
    }
    
    function tourBorrowerMobile() {
    
        mobile_tour_seller.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Al cambiar el tipo de usuario de Inversor a Vendedor, los tableros abajo contienen la información relevante a la venta de documentos.</p>`,
            attachTo: {
                element: '#sel_wrapfirst',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_borrower_1'
        });
    
        mobile_tour_seller.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí se muestran el total de documentos vendidos sobre operaciones concretadas.</p>`,
            attachTo: {
                element: '.mobile_bor_tur_first',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_borrower_2'
        });
    
        mobile_tour_seller.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Las ofertas recibidas vas a poder ver de forma rapida aqui con el valor mismo y el valor nominal de los documentos. Podrás ver detalle de ofertas recibidas.</p>`,
            attachTo: {
                element: '.mobile_bor_tur_second',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_borrower_3'
        });
    
        mobile_tour_seller.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Aquí podrás ver un resumen del total percibido sobre lo vendido en detalle.</p>`,
            attachTo: {
                element: '.mobile_bor_tur_third',
                on: 'top'
            },
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_borrower_4'
        });
    
        mobile_tour_seller.start();
    }
    
    function tourExploreOperationMobile() {
    
        mobile_tour_explore.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Bienvenido al Mercado de Operaciones, aqui podras encontrar todos los documentos cargados en la plataforma, y ofertar por los mismos el valor que consideres oportuno!</p>`,
            attachTo: {
                element: '.mobile_expop_wrap .titlebox h2',
                on: 'top'
            },
            highlightClass: 'h2',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_explore_operation_1'
        });
        mobile_tour_explore.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Haciendo click aqui, podrás ver un resumen de las ofertas enviadas, pudiendo visualizar historiales de ofertas y contraofertas, asi como tambien revertir las mismas en caso de querer retractarse antes de ser aceptada.</p>`,
            attachTo: {
                element: '.sentbtnbox',
                on: 'top'
            },
            highlightClass: '.sentbtnbox',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_explore_operation_2'
        });
        mobile_tour_explore.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Si estas convencido de las operaciones que te figuran en el mercado y queres ofertar por una o por varias, podes seleccionar las mismas y apretar ofertar.</p>`,
            attachTo: {
                element: '.mb_operationbox',
                on: 'top'
            },
            highlightClass: '.mb_operationbox',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_explore_operation_3'
        });
        mobile_tour_explore.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Luego de seleccionada la operación, haz click aqui para ver resumen de tu oferta, con utilidad neta, asi como tambien posibilidad de realizar ofertas grupales, agrupando las mismas por vendedor y por tipo.</p>`,
            attachTo: {
                element: '.mb_operationbox .rightpart p',
                on: 'top'
            },
            highlightClass: '.mb_operationbox .rightpart p',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_explore_operation_4'
        });
        mobile_tour_explore.start();
    }
    
    function tourOperationMobile() {
    
        mobile_tour_operation.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>En caso de haber adquirido el documento con servicio de MIPO+, garantizándose el recupero de inversión, podra visualizar aqui documentos comprados normalmente vs los que tienen recompra garantizada de nuestra parte. Al ingresar podra ver como esta dividida su cartera de inversión.</p>`,
            attachTo: {
                element: '.mobile_operations_left .mob_title',
                on: 'top'
            },
            highlightClass: '.mob_title',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_my_operation_1'
        });
    
        mobile_tour_operation.start();
    }
    
    function tourCreateOperationMobile() {
        mobile_tour_create_op.addStep({
            title: `${paco_img_tag}`,
            text: `<h6>Paco</h6><p>Bienvenido a Mis Operaciones, aqui encontraras las ofertas recibidas por inversores, las operaciones cargadas para venta con su actual estado (aprobacion/rechazo) y Tu Perfil, que resume tu posición en la plataforma, siendo lo que terceros pueden visualizar publicamente.</p>`,
            attachTo: {
                element: '.cr_iconbox .plus_iconbox',
                on: 'top'
            },
            highlightClass: '.plus_iconbox',
            buttons: [{
                action() {
                    return this.back();
                },
                classes: 'shepherd-button-secondary',
                text: 'Previo'
            },
            {
                action() {
                    return this.next();
                },
                text: 'Continuar'
            }
            ],
            id: 'mobile_create_operation_1'
        });
    
        mobile_tour_create_op.start();
    }
}

function detectDeviceTypeTour() {
    // Get the screen width using jQuery
    var screenWidth = $(window).width();

    // Define breakpoints for mobile and tablet
    var mobileBreakpoint = 768; // Example breakpoint for mobile (adjust as needed)
    var tabletBreakpoint = 991; // Example breakpoint for tablet (adjust as needed)

    // Determine the device type based on screen width
    if (screenWidth < mobileBreakpoint) {
        return "mob";
    } else if (screenWidth < tabletBreakpoint) {
        return "mob";
    } else {
        return "dst";
    }
}