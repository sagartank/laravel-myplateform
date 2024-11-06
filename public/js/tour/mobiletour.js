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

    mobile_tour_4.addStep({
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

    mobile_tour_4.start();
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