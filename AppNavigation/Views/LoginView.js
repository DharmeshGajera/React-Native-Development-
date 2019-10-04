import React from 'react';
import { View, Text, TouchableOpacity, Image, ActivityIndicator, Alert } from 'react-native';
import { Container, Header, Item, Input, Label, Body } from 'native-base';
import Styles from '../Assets/Css/Styles.js';
import APIHelper from '../Helpers/APIHelper';
import * as Font from 'expo-font';

export default class LoginView extends React.Component {
    constructor() {
        super();
        global.apiUrl = 'https://gum.digital/plesk-site-preview/accenture-fidelizados.com/';
        this.state = {
            username: '',
            password: '',
            isLoading: false,
            fontsLoaded: false,
        };
        this._isMounted = true;
    }

    async componentDidMount(){
        await Font.loadAsync({
            GothamBold: require('../Assets/Fonts/Gotham/Gotham-Bold.ttf'),
            GothamLight: require('../Assets/Fonts/Gotham/Gotham-Light.ttf'),
            GothamBook: require('../Assets/Fonts/Gotham/Gotham-Book.ttf')
        });
        this.setState({fontsLoaded: true});
    }

    validateLogin() {
        if (this.state.username != '' && this.state.password != '') {
            this._login();
        } else {
            Alert.alert("Complete Usuario y Contraseña.", "Vuelva a Intentarlo");
        }
    }

    componentWillUnmount() {
        this._isMounted = false;
      }

    async _login () {
        this.setState({
            isLoading: true,
        });
        const username = this.state.username;
        const password = this.state.password;
        const url = 'admin/api/usuario/login.php?username="'+username+'"&password="'+password+'"';
        const response = await APIHelper.get(url);
        if (this._isMounted) {
            this.setState({
                isLoading: false,
                dataLogin: (!response)?'':response.records
            });
        }
        if (this.state.dataLogin) {
            const usuario = this.state.dataLogin[0];
            global.id = usuario.id;
            global.nombre = usuario.nombre;
            global.apellido = usuario.apellido;
            global.email = usuario.email;
            global.archivo = usuario.archivo;
            this.props.navigation.replace('MainApp');
        } else {
            Alert.alert("Datos Incorrectos.", "Vuelva a Intentarlo");
        }
    }

    isLoading() {
        if (this.state.isLoading) {
            return (
                <Image
                    source={require('../Assets/Images/loading.gif')}  
                    style={Styles.loadingGif}
                />
            )
        }
    }

    render() {
        if (this.state.fontsLoaded) {
            return(
                <Container>
                    <Header style={Styles.headerStyle}>
                        <Body style={{flex: 3}}>
                            <Text style={Styles.headerTitle}>Club de Embajadores</Text>
                        </Body>
                    </Header>
                    <View style={Styles.viewContainerLogin}>
                        <View style={Styles.containerLogin}>
                            <Image source={require('../Assets/Images/logo.png')} style={Styles.logo} />
                            <View>
                                <Item floatingLabel style={Styles.viewInputsLogin}>
                                    <Label style={Styles.textOlvidoClave}>Usuario / Email</Label>
                                    <Input style={Styles.textOlvidoClave}
                                            autoCapitalize='none'
                                            onChangeText={(username) => this.setState({username})}
                                            value={this.state.username}
                                    />
                                </Item>
                            </View>
                            {this.isLoading()}
                            <View style={{marginTop: 10}}>
                                <Item floatingLabel style={Styles.viewInputsLogin}>
                                    <Label style={Styles.textOlvidoClave}>Contraseña</Label>
                                    <Input secureTextEntry={true}
                                            style={Styles.textOlvidoClave}
                                            onChangeText={(password) => this.setState({password})}
                                            value={this.state.password}
                                    />
                                </Item>
                            </View>
                            <TouchableOpacity
                                onPress={()=>this.validateLogin()}
                                style={Styles.botonIngresar}
                            >
                                <Text style={Styles.botonEnviarMailTexto}>INGRESAR</Text>
                            </TouchableOpacity>
                            <View style={Styles.botonRecuperarClave}>
                                <TouchableOpacity onPress={()=>{ this.props.navigation.navigate('OlvidoClave') }}>
                                    <Text style={Styles.botonRecuperarClaveTexto}>Recuperar Contraseña</Text>
                                </TouchableOpacity>
                            </View>
                        </View>
                    </View>
                </Container>
            );
        } else {
            return(
                <View style={Styles.activityIndicator}>
                    <ActivityIndicator/>
                </View>
            )
        }
    }
}