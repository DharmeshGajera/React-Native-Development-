import React from 'react';
import { View, Text, TouchableOpacity, ImageBackground, Image, ScrollView, ActivityIndicator, Linking } from 'react-native';
import { Container, Header, Left, Icon, Body, Right, Title, List, ListItem, Card, CardItem, CheckBox } from 'native-base';
import Styles from '../Assets/Css/Styles.js';
import IconAwesome from 'react-native-vector-icons/FontAwesome';
import APIHelper from '../Helpers/APIHelper';

export default class UsuariosDetalleView extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			check1: false,
			check2: false,
			check3: false,
			isLoading1: true,
			isLoading2: true,
		};
		const { navigation } = this.props;
    	this.id = navigation.getParam('id', '');
    	this._getEmbajadorInteres();
    	this._getEmbajadorRedsocial();
	}

	async _getEmbajadorInteres() {
		const url = 'admin/api/usuario/get_embajador_interes.php?id='+this.id;
        const response = await APIHelper.get(url);
        this.setState({
            isLoading1: false,
            dataUsuarioInteres: (!response)?'':response.records
        });
    }

    async _getEmbajadorRedsocial() {
		const url = 'admin/api/usuario/get_embajador_redsocial.php?id='+this.id;
        const response = await APIHelper.get(url);
        this.setState({
            isLoading2: false,
            dataUsuarioRedsocial: (!response)?'':response.records
        });
    }

    renderIconRedsocial($nombreRed) {
    	if($nombreRed == 'Facebook') {
    		return(
    			<Icon style={{color: '#2d428b'}} active name="logo-facebook" />
    		);
    	} else if($nombreRed == 'Twitter') {
    		return(
    			<Icon style={{color: '#469ae9'}} active name="logo-twitter" />
    		);
    	} else if($nombreRed == 'Linkedin') {
    		return(
    			<Icon style={{color: '#0d66a7'}} active name="logo-linkedin" />
    		);
    	} else if($nombreRed == 'Googleplus') {
    		return(
    			<Icon style={{color: 'red'}} active name="logo-googleplus" />
    		);
    	}
    }

    renderRedes() {
    	if (this.state.dataUsuarioRedsocial) {
    		return (
    			<View style={{width: '100%', paddingLeft: '5%', backgroundColor: '#fff'}}>
                    <ScrollView>
                    	{
	                        this.state.dataUsuarioRedsocial.map(( item, key ) => (
                                <TouchableOpacity
                                    key = { key }
                                    onPress={()=>{Linking.openURL(item.link)}}
                                >
    	                            <View style={[Styles.rowView, Styles.userRedSocialView]}>
    									{this.renderIconRedsocial(item.red_social)}
    									<Text style={Styles.userRedSocialText}>{item.red_social}</Text>
    									<Right>
    										<Icon style={{color: '#000'}} name="arrow-forward" />
    									</Right>
    	                            </View>
                                </TouchableOpacity>
	                        ))
	                    }
                    </ScrollView>
                </View>
    		);
    	} else {
    		return(
                <Text style={Styles.noDataEndpoint}>No hay Redes Sociales cargadas</Text>
            )
    	}
    }

    renderIntereses() {
    	if (this.state.dataUsuarioInteres) {
    		return (
    			<View style={{width: '100%', paddingLeft: '5%', backgroundColor: '#fff'}}>
	            	<ScrollView>
	                	{
	                        this.state.dataUsuarioInteres.map(( item, key ) => (
	                        	<View key = { key } style={[Styles.rowView, Styles.userInteresView]}>
						            <Body>
						            	<Text style={Styles.userInteresText}> {item.interes}</Text>
						            </Body>
	                            </View>
	                        ))
	                    }
	                </ScrollView>
				</View>
    		);
    	} else {
    		return(
                <Text style={Styles.noDataEndpoint}>No hay Intereses cargados</Text>
            )
    	}
    }

    render() {
    	if(this.state.isLoading1 || this.state.isLoading2){
            return(
                <View style={{flex: 1, padding: 20}}>
                  <ActivityIndicator/>
                </View>
            )
        }
        const embajador = this.state.dataUsuarioInteres[0];
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
                <View style={Styles.container}>
		            <View style={{width: '100%', height: '100%', backgroundColor: '#fff'}}>
                        <View style={Styles.rowView}>
    		                <View style={Styles.viewInfoUser}>
    		                    <Text style={Styles.nameUser}>{embajador['nombre']} {embajador['apellido']}</Text>
    		                    <Text style={Styles.emailUser}>{embajador['email']}</Text>
    		                </View>
                            <View style={{width: '35%'}}>
                                <Image
                                    source={{uri: global.apiUrl+'archivos/'+embajador['archivo']}}
                                    style={Styles.imageUser}
                                />
                            </View>
                        </View>
                        <View style={{width: '90%', marginLeft: '5%', marginTop: 20}}>
                        	<View style={[Styles.rowView, {padding: 5}]}>
	                            <Text style={Styles.titleContenido}>Redes Sociales</Text>
	                        </View>
	                    </View>
	                    {this.renderRedes()}
                        <View style={[Styles.rowView, {marginTop: 25, padding: 5, marginLeft: '5%'}]}>
                            <Text style={Styles.titleContenido}>Intereses</Text>
                        </View>
                        {this.renderIntereses()}
		            </View>
		        </View>
		    </Container>
        );
    }
}