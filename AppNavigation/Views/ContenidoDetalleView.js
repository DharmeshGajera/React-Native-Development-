import React from 'react';
import { View, TouchableOpacity, Image, Linking, ScrollView, ActivityIndicator, Dimensions } from 'react-native';
import { Container, Header, Content, List, ListItem, Left, Body, Right, Text, Icon, Button, Title, Card, CardItem, Badge } from 'native-base';
import Styles from '../Assets/Css/Styles.js';
import Hr from '../GenericComponents/Hr';
import IconAwesome from 'react-native-vector-icons/FontAwesome';
import APIHelper from '../Helpers/APIHelper';

export default class ContenidoDetalleView extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			isLoading1: true,
			isLoading2: true,
			isLoading3: true,
		};
		const { navigation } = this.props;
    	this.id = navigation.getParam('id', '');
    	this._getContenido();
    	this._getInteres_Contenido();
    	this._getRedes_Usuario();
	}

	async _getContenido() {
		const url = 'admin/api/contenido/get_contenido.php?id='+this.id;
        const responseContenido = await APIHelper.get(url);
        this.setState({
            isLoading1: false,
            dataContenido: (!responseContenido)?'':responseContenido.records,
            codigo: (!responseContenido)?'':responseContenido.records[0].codigo
        });
    }

    async _getInteres_Contenido() {
		const url = 'admin/api/contenido/get_interes_contenido.php?id='+this.id;
        const responseInteres = await APIHelper.get(url);
        this.setState({
            isLoading2: false,
            dataInteres: (!responseInteres)?'':responseInteres.records
        });
    }

    async _getRedes_Usuario() {
		const url = 'admin/api/usuario/get_redes_usuario.php?id='+global.id;
        const responseRedes = await APIHelper.get(url);
        this.setState({
            isLoading3: false,
            dataRedes: (!responseRedes)?'':responseRedes.records
        });
    }

    renderIconRedsocial($nombreRed) {
    	if($nombreRed == 'Facebook') {
    		return(
    			<IconAwesome name="facebook" style={Styles.botonIcon} />
    		);
    	} else if($nombreRed == 'Twitter') {
    		return(
    			<IconAwesome name="twitter" style={Styles.botonIcon} />
    		);
    	} else if($nombreRed == 'Linkedin') {
    		return(
    			<IconAwesome name="linkedin" style={Styles.botonIcon} />
    		);
    	} else if($nombreRed == 'Googleplus') {
    		return(
    			<IconAwesome name="logo-googleplus" style={Styles.botonIcon} />
    		);
    	}
    }

    renderStyleRedSocialButton($nombreRed) {
    	if($nombreRed == 'Facebook') {
    		return Styles.botonFacebook;
    	} else if($nombreRed == 'Twitter') {
    		return Styles.botonTwitter;
    	} else if($nombreRed == 'Linkedin') {
    		return Styles.botonLinkedin;
    	} else if($nombreRed == 'Googleplus') {
    		return Styles.botonGoogleplus;
    	}
    }

    renderFecha($fecha) {
    	var dia = new Date().getDate();
    	var mes = new Date().getMonth() + 1;
    	var ano = new Date().getFullYear();

    	//return dia+'/'+mes+'/'+ano;
    	const fecha = String($fecha).split(' 00:00:00');
    	var days = String(fecha[0]).split('-');

    	return days[2] + '-' + days[1] + '-' + days[0];
    }

    async sumarPuntosAlCompartir($link) {
        const url = "admin/api/usuario/sumar_puntos.php?id="+global.id+"&codigo='"+this.state.codigo+"'";
        const response = await APIHelper.get(url);
        Linking.openURL($link);
    }

    renderRedes() {
        if (this.state.dataRedes) {
            return (
                <View style={[Styles.rowView, {justifyContent: 'center', marginTop: 5}]}>
                    {
                        this.state.dataRedes.map(( item, key ) => (
                            <TouchableOpacity
                                key = { key }
                                onPress={()=>{this.sumarPuntosAlCompartir(item.link)}}
                                style={this.renderStyleRedSocialButton(item.nombre)}
                            >
                                {this.renderIconRedsocial(item.nombre)}
                            </TouchableOpacity>
                        ))
                    }
                </View>
            )
        } else {
            return(
                <Text style={{margin: 20}}>No hay Redes Sociales cargadas</Text>
            )
        }
    }

	render() {
        const dimensions = Dimensions.get('window');
        const imageHeight = Math.round(dimensions.width * 9 / 16);
        const imageWidth = dimensions.width * 0.89;

		if(this.state.isLoading1 || this.state.isLoading2 || this.state.isLoading3){
            return(
                <View style={{flex: 1, padding: 20}}>
                  <ActivityIndicator />
                </View>
            )
        }
        const contenido = this.state.dataContenido[0];
        const urlImage = (global.apiUrl+'archivos/'+contenido.archivo);
		return (
			<Container>
                <Header style={Styles.headerStyle}>
                    <Left style={Styles.headerLeft}>
                        <TouchableOpacity
                            onPress={()=>this.props.navigation.goBack()}
                        >
                            <Icon name='arrow-back' style={Styles.headerIcon} />
                        </TouchableOpacity>
                    </Left>
                    <Body style={{flex: 3}}>
                        <Text style={Styles.headerTitle}>Club de Embajadores</Text>
                    </Body>
                    <Right />
                </Header>
				<Content style={Styles.Container}>
                    <Card style={{width: '96%', marginLeft: '2%'}}>
                        <CardItem>
                            <Body>
                                <Image
                                    source={{uri: urlImage}}
                                    style={{width: imageWidth, height: imageHeight, alignSelf: 'auto', flex: 1}}
                                />
                                
                                <ScrollView horizontal={true} style={[Styles.rowView, scrollIntereses]}>
                                    {
                                        this.state.dataInteres.map(( item, key ) => (
                                            <Badge key = { key } style={{backgroundColor: "#"+item.color}}>
                                                <Text style={{fontFamily: 'GothamBook'}}>{item.nombre}</Text>
                                            </Badge>
                                        ))
                                    }
                                </ScrollView>
                                <View style={Styles.rowView}>
                                    <Text style={Styles.tituloNovedad}>{contenido.titulo}</Text>
                                </View>
                                <Text style={Styles.fechaNovedad}>{this.renderFecha(contenido.fecha_publicacion)}</Text>
                                <Text style={Styles.bajadaNovedad}>{contenido.bajada}</Text>
                                <View style={[Styles.rowView, {marginTop: 20}]}>
                                    <Text style={Styles.compartirNovedad}>Compartir en Redes Sociales</Text>
                                </View>
                                {this.renderRedes()}
                            </Body>
                        </CardItem>
                    </Card>
				</Content>
			</Container>
		);
	}
}