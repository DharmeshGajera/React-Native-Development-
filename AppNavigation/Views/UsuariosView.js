import React from 'react';
import { View, Text, Image, TouchableOpacity, Linking, ScrollView, ImageBackground, ActivityIndicator } from 'react-native';
import { Container, Header, Left, Icon, Body, Right, Title, List, ListItem } from 'native-base';
import Styles from '../Assets/Css/Styles';
import IconAwesome from 'react-native-vector-icons/FontAwesome';
import APIHelper from '../Helpers/APIHelper';

export default class UsuariosView extends React.Component {
    constructor(props){
        super(props);
        this.state = { isLoading: true }
        this._getManagers();
    }

    async _getManagers() {
        const response = await APIHelper.get('admin/api/usuario/list_managers.php');
        this.setState({
            isLoading: false,
            dataSource: (!response)?'':response.records
        });
    }

    renderElement() {
        if (this.state.dataSource){
            return (
                <ScrollView>
                    {
                        this.state.dataSource.map(( item, key ) => (
                            <ListItem key = { key }>
                                <TouchableOpacity style={{width: '100%'}} onPress={()=>{ this.props.navigation.navigate('UsuariosDetalle', {
                                        id: item.id
                                    });
                                }}>
                                    <View style={[Styles.rowView]}>
                                        <View style={{width: '15%'}}>
                                            <Image
                                                source={{uri: global.apiUrl+'archivos/'+item.archivo}}
                                                style={{width: 40, height: 40, borderRadius: 20}}
                                            />
                                        </View>
                                        <View style={{width: '80%', justifyContent: 'center'}}>
                                            <Text style={{fontSize: 18, fontFamily: 'GothamBook'}}>{item.nombre} {item.apellido}</Text>
                                        </View>
                                        <View style={{width: '5%', justifyContent: 'center'}}>
                                            <Icon style={{color: '#000', fontSize: 25}} name="arrow-forward" />
                                        </View>
                                    </View>
                                </TouchableOpacity>
                            </ListItem>
                        ))
                    }
                </ScrollView>
            );
        } else {
            return(
                <Text style={Styles.noDataEndpoint}>No hay Embajadores</Text>
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
                                    <Text style={Styles.titleContenido}>EMBAJADORES</Text>
                                    <Text style={Styles.subtitleContenido}>Aquí tendrás acceso a todos los embajadores del sistema.</Text>
                                    <Text style={Styles.subtitleContenido}>Podrás ver los intereses de cada uno</Text>
                                    <Text style={Styles.subtitleContenido}>junto con su información personal.</Text>
                                </View>
                            </ImageBackground>
                        </View>
                        <View style={[Styles.rowView, {padding: 5, borderBottomColor: '#eeeff1', borderBottomWidth: 3}]} />
        		        { this.renderElement() }
                    </View>
                </View>
	        </Container>
        );
    }
}