import React from 'react';
import { View, Text, TouchableOpacity, ScrollView, Image, Alert, ImageBackground, ActivityIndicator, FlatList } from 'react-native';
import { Container, Header, Left, Icon, Body, Right, Title, Card, CardItem } from 'native-base';
import Styles from '../Assets/Css/Styles.js';
import APIHelper from '../Helpers/APIHelper';
import Ranking from '../GenericComponents/Ranking';

export default class LastNewsView extends React.Component {
    constructor(props){
        super(props);
        this.state = { isLoading: true }
        this._getLastNews();
    }

    async _getLastNews() {
        const response = await APIHelper.get('admin/api/contenido/get_last_news.php?id='+global.id);
        this.setState({
            isLoading: false,
            dataNews: (!response)?'empty':response.records
        });
    }

    renderNews() {
        if (this.state.dataNews == 'empty') {
            return (
                <Text style={Styles.noDataEndpoint}>No hay Ultimas Noticias</Text>
            );
        } else if (this.state.dataNews) {
            return(
                <View>
                    {
                       this.state.dataNews.map(( item, key ) => (
                            this.renderNew(item, key + 1)
                       ))
                    }
                </View>
            )
        } else {
            return(
                <View style={{flex: 1, padding: 20}}>
                  <ActivityIndicator/>
                </View>
            )
        }
    }

    renderNew($item, $cont) {
        const item = $item;
        const urlImages = ('archivos/'+item.archivo);
        if ($cont == 1) {
            return (
                <TouchableOpacity key = { $cont } onPress={()=>{ this.props.navigation.navigate('ContenidoDetalle', {
                        id: item.id
                    });
                }}>
                    <Card style={Styles.cardWidth}>
                        <CardItem>
                            <Body style={{height: 500}}>
                                <Image
                                    source={{uri: global.apiUrl+urlImages}}
                                    style={Styles.principalImage}
                                />
                                <View style={Styles.rowView}>
                                    <Text style={Styles.textPrincipalImage}>{item.titulo}</Text>
                                </View>
                            </Body>
                        </CardItem>
                    </Card>
                </TouchableOpacity>
            );
        } else {
            return (
                <TouchableOpacity key = { $cont } onPress={()=>{ this.props.navigation.navigate('ContenidoDetalle', {
                        id: item.id
                    });
                }}>
                    <Card style={Styles.cardWidth}>
                        <CardItem>
                            <Body style={Styles.rowView}>
                                <View style={{width: '50%'}}>
                                    <Text style={Styles.textSecundaryImage}>{item.titulo}</Text>
                                </View>
                                <View style={{width: '50%', paddingTop: 5}}>
                                    <Image
                                        source={{uri: global.apiUrl+urlImages}}
                                        style={Styles.imageUltimasNoticias}
                                    />
                                </View>
                            </Body>
                        </CardItem>
                    </Card>
                </TouchableOpacity>
            );
        }
    }

    render() {
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
                    <View style={[Styles.colView, {height: '100%', flex: 1, width: '100%'}]}>
                        <ScrollView>
                            {this.renderNews()}
                            <Ranking />
                        </ScrollView>
                    </View>
                </View>
		    </Container>
        );
    }
}