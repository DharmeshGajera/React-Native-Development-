import { StyleSheet, Platform, StatusBar } from 'react-native';

export default StyleSheet.create({
    containerLogin: {
        flex: 1,
        alignItems: 'center',
        flexDirection: 'column',
        marginTop: 20,
    },
    viewContainerLogin: {
        width: '100%',
        height: '100%',
        backgroundColor: '#fff'
    },
    textOlvidoClave: {
        fontSize: 16,
        color: '#127AB7',
        fontFamily: 'GothamLight'
    },
    botonEnviarMail: {
        marginTop: 20,
        backgroundColor:'#127AB7',
        width: '80%',
        padding: 15,
        alignItems: 'center'
    },
    botonRecuperarClave: {
        marginTop: 10,
        alignSelf: 'flex-end'
    },
    botonRecuperarClaveTexto: {
        color: '#127AB7',
        marginRight: '10%',
        fontFamily: 'GothamLight'
    },
    botonEnviarMailTexto: {
        color: '#fff',
        fontFamily: 'GothamBold'
    },
    botonIngresar: {
        marginTop: 20,
        backgroundColor:'#127AB7',
        width: '80%',
        padding: 15,
        alignItems: 'center'
    },
    viewInputsLogin: {
        width: '80%',
        color: '#127AB7'
    }, 
    container: {
        flex: 1,
        alignItems: 'center',
        flexDirection: 'column',
    },
    rowView: {
        flexDirection: 'row',
    },
    colView: {
        flexDirection: 'column',
    },
    titlePageBlack: {
        color: '#000',
        fontFamily: 'GothamBold',
        fontSize: 25,
        marginTop: 20,
        marginBottom: 20,
        marginLeft: 20,
    },
    viewContenido: {
        marginLeft: '5%',
        marginRight: '5%',
        marginBottom: 10,
        width: '90%',
        backgroundColor: 'lightgrey',
        flexDirection: 'row',
        borderRadius: 10,
        borderColor: '#000',
        borderWidth: 1,
        padding: 10,
    },
    viewTextosContenido: {
        flexDirection: 'column',
        width: '100%',
    },
    viewDescripcionContenido: {
        width: '96%',
        marginLeft:'2%',
        marginRight:'2%',
        alignItems:'center'
    },
    fondoDescripcionContenido: {
        width: '100%',
        height: '100%',
        justifyContent:'center'
    },
    titleContenido: {
        color: '#fff',
        fontSize: 18,
        marginBottom: 10,
        fontFamily: 'GothamBold'
    },
    subtitleContenido: {
        color: '#fff',
        fontSize: 13,
        fontFamily: 'GothamLight'
    },
    titleIntereses: {
        justifyContent: 'center',
        padding: 5,
        borderBottomColor: '#eeeff1',
        borderBottomWidth: 3
    },
    tituloNovedad: {
        fontSize: 22,
        fontFamily: 'GothamBold'
    },
    fechaNovedad: {
        color: '#B0AEAE',
        fontSize: 17,
        fontFamily: 'GothamLight'
    },
    bajadaNovedad: {
        marginTop: 20,
        fontFamily: 'GothamBook'
    },
    compartirNovedad: {
        justifyContent: 'center',
        alignItems: 'center',
        fontSize: 18,
        fontFamily: 'GothamBold'
    },
    titleContenidoDetalle: {
        fontSize: 22,
        marginLeft:'5%',
        marginRight:'5%'
    },
    subtitleContenidoDetalle: {
        fontSize: 15,
        color:'#AEADB3',
        marginLeft:'5%',
        marginRight:'5%',
        marginTop:10,
    },
    headerStyle: {
        height: 75,
        backgroundColor: '#f6f8fa'
    },
    headerTitle: {
        color: '#000',
        fontFamily: 'GothamBold',
        fontSize: 18,
    },
    logoHeader: {
        fontSize: 30,
        marginLeft: 20,
    },
    logo: {
        width: '50%',
    },
    loadingGif: {
        width: 50,
        height: 50,
        position: 'absolute',
        alignItems:'center',
        justifyContent:'center'
    },
    headerTitle: {
        fontFamily: 'GothamBold',
        fontSize: 22,
        marginTop: 5,
        paddingTop: Platform.OS === 'ios' ? 0 : StatusBar.currentHeight
    },
    headerLeft: {
        paddingTop: Platform.OS === 'ios' ? 0 : StatusBar.currentHeight
    },
    headerIcon: {
        fontSize: 40,
        marginLeft: 10,
        marginRight: 10
    },
    headerLogout: {
        fontSize: 35,
        marginLeft: 10
    },
    activityIndicator: {
        flex: 1,
        padding: 20
    },
    tituloNoticia: {
        fontSize: 18,
        padding: 5,
        fontFamily: 'GothamBook'
    },
    scrollIntereses: {
        marginTop: 10,
        marginBottom: 10,
        marginRight: '5%'
    },
    noDataEndpoint: {
        margin: 20,
        fontFamily: 'GothamLight'
    },
    cardWidth: {
        width: '96%',
        marginLeft: '2%'
    },
    principalImage: {
        width: '100%',
        height: 'auto',
        alignSelf: 'auto',
        flex: 1
    },
    textPrincipalImage: {
        fontSize: 22,
        marginTop: 20,
        marginBottom: 20,
        fontFamily: 'GothamBook'
    },
    textSecundaryImage: {
        fontSize: 18,
        padding: 5,
        fontFamily: 'GothamBook'
    },
    textoBotones: {
        color: '#fff',
        fontSize: 18,
        fontFamily: 'GothamBold',
        letterSpacing: 2,
    },
    botonHabilitado: {
        alignItems:'center',
        justifyContent:'center',
        padding: 12,
        margin: 5,
        width: '65%',
        backgroundColor: '#00af6c',
        borderRadius: 10,
    },
    viewInputsLogin: {
        width: '80%',
        color: '#127AB7'
    },
    usuarioLogin: {
        width: '70%',
        paddingBottom: 5,
        borderBottomColor: '#AEADB3',
        borderBottomWidth: 1,
        color: '#AEADB3',
        fontSize: 16,
        letterSpacing: 2,
    },
    claveLogin: {
        width: '70%',
        color: '#AEADB3',
        fontSize: 16,
        marginBottom: 20,
        letterSpacing: 2,
    },
    linkOlvidoClave: {
        color: '#fff',
        fontSize: 20,
        marginTop: 10,
    },
    linkVerTodoContenido: {
    	textDecorationLine: 'underline',
    	color: '#fff',
        letterSpacing: 1,
        marginTop: 10,
    },
    linkContenidoCompleto: {
    	textDecorationLine: 'underline',
    	color: '#0086e5',
    	alignSelf: 'flex-end',
    	marginRight: 20,
        marginTop: 10,
    },
    botonLogin: {
        backgroundColor: '#0086e5',
        borderRadius: 5,
        padding: 10,
        paddingTop: 0,
        width: 100,
        alignItems: 'center',
        justifyContent:'center',
    },
    botonTwitter: {
        alignItems: 'center',
        padding: 10,
        backgroundColor: '#0086e5',
        borderRadius: 20,
        width: '10%',
        marginLeft: 10,
        marginBottom: 10,
    },
    botonFacebook: {
        alignItems: 'center',
        padding: 10,
        backgroundColor: '#4267b2',
        borderRadius: 20,
        width: '10%',
        marginLeft: 10,
        marginBottom: 10,
    },
    botonLinkedin: {
        alignItems: 'center',
        padding: 10,
        backgroundColor: '#283e4a',
        borderRadius: 20,
        width: '10%',
        marginLeft: 10,
        marginBottom: 10,
    },
    botonGoogleplus: {
        alignItems: 'center',
        padding: 10,
        backgroundColor: '#d23935',
        borderRadius: 20,
        width: '10%',
        marginLeft: 10,
        marginBottom: 10,
    },
    botonIcon: {
        color: '#fff',
        fontSize: 18,
    },
    ingresarHeader: {
    	color: '#AEADB3',
    	marginRight: 20,
    },
    dashboardHeader: {
    	color: '#AEADB3',
    	marginLeft: 20,
    },
    SectionStyle: {
	    flexDirection: 'row',
	    justifyContent: 'center',
	    alignItems: 'center',
        borderRadius: 30,
        borderColor: '#fff',
        borderWidth: 1,
	},
    imageSignInPerson: {
        height: 70,
        width: 70,
        resizeMode: 'stretch',
        alignItems: 'center',
    },
	ImageStyle: {
	    marginTop: 10,
	    height: 30,
	    width: 30,
	    resizeMode: 'stretch',
	    alignItems: 'center',
	},
	iconoHeader: {
        fontSize: 25,
        margin: 10,
    },
    nombreDirector: {
        fontSize: 22,
        color: '#000',
    },
    loginBlock: {
        justifyContent: 'center',
        alignItems: 'center',
        borderRadius: 20,
        backgroundColor: '#ffffff7a',
        paddingLeft: 20,
        paddingRight: 20,
        paddingBottom: 20,
        width: '90%',
    },
    subtituloDashboard: {
        marginLeft: '5%',
        marginRight: '5%',
    },
    botonDashboard: {
        alignItems:'center',
        justifyContent:'center',
        padding: 5,
        margin: 5,
        width: '65%',
        backgroundColor: '#fff',
        borderRadius: 5,
    },
    textoBotonDashboard: {
        color: '#000',
        fontSize: 15,
        fontFamily: 'GothamBold',
    },
    usuarioLogin: {
        width: '70%',
        borderBottomColor: '#AEADB3',
        borderBottomWidth: 1,
        marginBottom: 30,
        color: '#AEADB3',
        fontFamily: 'GothamBold',
        fontSize: 16,
    },
    claveLogin: {
        width: '70%',
        borderBottomColor: '#AEADB3',
        borderBottomWidth: 1,
        marginBottom: 20,
        color: '#AEADB3',
        fontFamily: 'GothamBold',
        fontSize: 16,
    },
    linkOlvidoClave: {
        color: '#AEADB3',
        letterSpacing: 1,
    },
    imagePrimerUltimaNoticia: {
        width: '100%',
        maxHeight: 400,
    },
    imageUltimasNoticias: {
        width: '100%',
        height: 100,
    },
    imageUser: {
        width: 100,
        height: 100,
        borderRadius: 50,
        alignSelf: 'flex-end',
        marginRight: 35,
        marginTop: 10
    },
    nameUser: {
        color: '#000',
        fontFamily: 'GothamBold',
        fontSize: 28,
        marginBottom: 5
    },
    emailUser: {
        color: '#000',
        fontSize: 15,
        fontFamily: 'GothamBook'
    },
    viewInfoUser: {
        width: '65%',
        marginTop: 25,
        marginLeft: 25
    },
    userInteresText: {
        alignSelf: 'flex-start',
        marginLeft: 20,
        width: '100%',
        fontFamily: 'GothamBook',
        fontSize: 16
    }
});