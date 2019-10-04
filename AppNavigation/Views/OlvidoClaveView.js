import React from 'react';
import { View, Text, TouchableOpacity, Linking, Alert, Platform, StatusBar, Image } from 'react-native';
import { Container, Header, Left, Body, Right, Icon, Item, Label, Input } from 'native-base';
import Styles from '../Assets/Css/Styles.js';
import APIHelper from '../Helpers/APIHelper';

export default class OlvidoClaveView extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            email: "empty"
        };
    }

    async sendEmail () {
        this.setState({
            isLoading: true,
        });
        const email = this.state.email;
        const url = 'admin/api/usuario/recuperar_clave.php?email='+email;
        const response = await APIHelper.get(url);
        this.setState({
            isLoading: false,
            dataResponse: (!response)?'':response.records
        });
        
        Alert.alert(this.state.dataResponse[0].mensaje);
        //this.props.navigation.goBack();
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
                <View style={Styles.viewContainerLogin}>
                    <View style={[Styles.containerLogin, {marginTop: 30}]}>
                        <Text style={[Styles.textOlvidoClave, {marginTop: 20}]}>Recibirás un email con las instrucciones</Text>
                        <Text style={Styles.textOlvidoClave}>para recuperar tu contraseña</Text>
                        <View style={{marginTop: 10}}>
                            <Item floatingLabel style={[Styles.viewInputsLogin, {marginTop: 30}]}>
                                <Label style={Styles.textOlvidoClave}>Email</Label>
                                <Input style={Styles.textOlvidoClave} autoCapitalize='none' onChangeText={(email) => this.setState({email})} />
                            </Item>
                        </View>
                        {this.isLoading()}
                        <TouchableOpacity
                            onPress={()=>this.sendEmail()}
                            style={Styles.botonEnviarMail}
                        >
                            <Text style={Styles.botonEnviarMailTexto}>Enviar Email</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </Container>
        );
    }
}