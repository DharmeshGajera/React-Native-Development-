import React from 'react';
import { View, Text, TouchableOpacity, ImageBackground, Image, ScrollView, Alert, TextInput, ActivityIndicator, Linking } from 'react-native';
import { Container, Header, Left, Icon, Body, Right, Title, List, ListItem, Card, CardItem, CheckBox} from 'native-base';
import Styles from '../Assets/Css/Styles.js';
import IconAwesome from 'react-native-vector-icons/FontAwesome';
import { StackActions, NavigationActions } from 'react-navigation';
import APIHelper from '../Helpers/APIHelper';

export default class PerfilView extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
            check: 1,
			isLoading1: true,
			isLoading2: true,
		}
		this._getInteresUsuario();
    	this._getRedsocialUsuario();
	}

	logout() {
		Alert.alert(
	      'Confirmar',
	      'Estas seguro que queres cerrar sesión?',
	      [
	          { text: 'Si', onPress: () => this.acceptedLogout() },
	          { text: 'Cancelar' }
	      ]
	    )
	}

	acceptedLogout() {
		global.id = '';
        global.nombre = '';
        global.apellido = '';
        global.email = '';
        const resetAction = StackActions.reset({
		  index: 0,
		  actions: [NavigationActions.navigate({ routeName: 'Login' })],
		});
	    this.props.navigation.dispatch(resetAction);
	}

	async _getInteresUsuario() {
		const url = 'admin/api/usuario/get_interes_usuario.php?id='+global.id;
        const response = await APIHelper.get(url);
        this.setState({
            isLoading1: false,
            dataUsuarioInteres: (!response)?'':response.records
        });
    }

    async _getRedsocialUsuario() {
		const url = 'admin/api/usuario/get_redes_usuario.php?id='+global.id;
        const response = await APIHelper.get(url);
        this.setState({
            isLoading2: false,
            dataUsuarioRedsocial: (!response)?'':response.records
        });
    }

    async guardarIntereses(id, value) {
        const url = 'admin/api/usuario/update_interes_usuario.php?id='+id+'&value='+value;
        console.log(url);
        const response = await APIHelper.get(url);
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
										{this.renderIconRedsocial(item.nombre)}
										<Text style={Styles.userRedSocialText}>{item.nombre}</Text>
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

    checkInteres(item, key) {
        const intereses = {};

        if (this.state['check_' + key] == 0 || this.state['check_' + key] == 1) {
            intereses['check_' + key] = !this.state['check_' + key];
        } else {
            //SI ESTA CHECKEADO, QUIERO DESCHECKEARLO, POR ESO EL FALSE Y EL TRUE VAN AL REVES
            intereses['check_' + key] = (item.checked == 1 ? false : true);
        }
        this.setState(intereses);
        this.guardarIntereses(item.id, intereses['check_' + key]);
    }

    renderIntereses() {
    	if (this.state.dataUsuarioInteres) {
    		return (
    			<View style={{width: '100%', paddingLeft: '5%', backgroundColor: '#fff'}}>
                	<ScrollView>
                    	{
	                        this.state.dataUsuarioInteres.map(( item, key ) => (
	                        	<View key = { key } style={[Styles.rowView, Styles.userInteresView]}>
                                    <CheckBox checked={(this.state['check_' + key] == 0 || this.state['check_' + key] == 1) ? this.state['check_' + key] : (item.checked == 1 ? true : false)} onPress={()=>this.checkInteres(item, key)} />
						            <Body>
						            	<Text style={Styles.userInteresText} onPress={()=>this.checkInteres(item, key)}>{item.nombre}</Text>
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
                  <ActivityIndicator />
                </View>
            )
        }
        return (
        	<Container>
				<Header style={Styles.headerStyle}>
                    <Left style={Styles.headerLeft}>
			            <TouchableOpacity
		                    onPress={()=>this.props.navigation.openDrawer()}
		                >
		              		<Icon name='menu' style={Styles.headerIcon} />
		            	</TouchableOpacity>
		          	</Left>
		          	<Right>
		          		<TouchableOpacity
		                    onPress={()=>this.logout()}
		                >
		              		<Icon name='log-out' style={Styles.headerLogout} />
		            	</TouchableOpacity>
		          	</Right>
		        </Header>
                <View style={Styles.container}>
		            <View style={{width: '100%', height: '100%', backgroundColor: '#fff'}}>
		                <View style={Styles.rowView}>
                            <View style={Styles.viewInfoUser}>
                                <Text style={Styles.nameUser}>{global.nombre+' '+global.apellido}</Text>
                                <Text style={Styles.emailUser}>{global.email}</Text>
                            </View>
                            <View style={{width: '35%'}}>
                                <Image
                                    source={{uri: global.apiUrl+'archivos/'+global.archivo}}
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