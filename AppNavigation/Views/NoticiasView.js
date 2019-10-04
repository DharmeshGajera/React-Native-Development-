import React from 'react';
import { View, TouchableOpacity, Image, ImageBackground, ScrollView, ActivityIndicator } from 'react-native';
import { Container, Header, Content, List, ListItem, Left, Body, Right, Text, Icon, Button, Title, Badge } from 'native-base';
import Styles from '../Assets/Css/Styles.js';
import Hr from '../GenericComponents/Hr';
import APIHelper from '../Helpers/APIHelper';

export default class NoticiasView extends React.Component {
	constructor(props) {
		super(props);
		this.state = { isLoading: true }
        this._getContenido();
	}

	async _getContenido() {
        const response = await APIHelper.get('admin/api/contenido/list_news.php?id='+global.id);
        this.setState({
            isLoading: false,
            dataSource: (!response)?'':response.records,
        });
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

    renderElement() {
    	if(this.state.dataSource){
            return(
                <ScrollView style={{marginLeft: '2%', marginRight: '2%'}}>
					<Hr
						color='#fff'
	                    extraStyles={{marginTop: 10}}
	                />
	                {
                        this.state.dataSource.map(( item, key ) => (
                        	<View key = { key }>
                            	<TouchableOpacity onPress={()=>{ this.props.navigation.navigate('ContenidoDetalle', {
		                                id: item.id
		                            });
		                        }}>
		                            <View style={Styles.rowView}>
		                                <View style={{width: '50%'}}>
		                                    <Text style={Styles.tituloNoticia}>{item.titulo}</Text>
		                                    <Badge style={{backgroundColor: "#" + item.color, marginBottom: 5}}>
									            <Text style={{fontFamily: 'GothamBook'}}>{item.interes}</Text>
									        </Badge>
		                                </View>
		                                <View style={{width: '50%', padding: 5}}>
		                                    <Image
		                                        source={{uri: global.apiUrl+'archivos/'+item.archivo}}
		                                        style={Styles.imageUltimasNoticias}
		                                    />
		                                </View>
		                            </View>
								</TouchableOpacity>
								<Hr
				                    extraStyles={{marginBottom: 10, marginTop: 10}}
				                />
				            </View>
                        ))
                    }
				</ScrollView>
            )
        } else {
        	return(
        		<Text style={Styles.noDataEndpoint}>No hay noticias</Text>
        	)
        }
    }

	render() {
		if(this.state.isLoading){
            return(
                <View style={Styles.activityIndicator}>
                 	<ActivityIndicator/>
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
                    <Body style={{flex: 3}}>
                        <Text style={Styles.headerTitle}>Club de Embajadores</Text>
                    </Body>
                    <Right />
		        </Header>
				<View style={Styles.container}>
					<View style={[Styles.colView, {height: '100%', width: '100%', flex: 1}]}>
						<View style={{height: 150}}>
	                        <ImageBackground source={require('../Assets/Images/fondo.jpg')} style={Styles.fondoDescripcionContenido}>
	                            <View style={Styles.viewDescripcionContenido}>
		                            <Text style={Styles.titleContenido}>NOTICIAS</Text>
		                            <Text style={Styles.subtitleContenido}>Conocé las Últimas Noticias del Club de Embajadores.</Text>
		                            <Text style={Styles.subtitleContenido}>Información actualizada las 24 horas</Text>
		                        </View>
	                        </ImageBackground>
	                    </View>
	                    <View style={[Styles.rowView, titleIntereses]}>
                            <View>
                                <Text style={{fontFamily: 'GothamBold'}}>Noticias según sus Intereses</Text>
                            </View>
                        </View>
                        { this.renderElement() }
					</View>
				</View>
			</Container>
		);
	}
}