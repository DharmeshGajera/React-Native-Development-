import React from 'react';
import { View, Text, ScrollView, Image, ActivityIndicator } from 'react-native';
import { Icon } from 'native-base';
import APIHelper from '../Helpers/APIHelper';
import Styles from '../Assets/Css/Styles.js';

export default class Ranking extends React.Component {
    constructor(props) {
        super(props);
        this.state = { isLoading: true };
        this._getManagers();
    }

    async _getManagers() {
        const response = await APIHelper.get('admin/api/usuario/list_managers_puntos.php');
        this.setState({
            isLoading: false,
            dataSource: (!response)?'empty':response.records
        });
    }

    renderTrophy($cont) {
        switch($cont) {
            case 1:
                return <Icon name="trophy" style={{fontSize: 25, color: '#FFD700'}} />
            case 2:
                return <Icon name="trophy" style={{fontSize: 25, color: '#C0C0C0'}} />
            case 3:
                return <Icon name="trophy" style={{fontSize: 25, color: '#cd7f32'}} />
            default:
                return null;
        }
    }

    render() {
        if (this.state.dataSource == 'empty'){
            return (
                <Text style={{margin: 20, fontFamily: 'GothamLight'}}>No hay Embajadores</Text>
            )
        } else if (this.state.dataSource) {
            return(
                <View style={{marginTop: 20}}>
                    <View style={[Styles.rowView, {justifyContent: 'center', padding: 5, borderBottomColor: '#eeeff1', borderBottomWidth: 1}]}>
                        <View style={{width: '10%', justifyContent: 'center', alignItems: 'center'}}></View>
                        <View style={{width: '60%', justifyContent: 'center'}}>
                            <Text style={[Styles.tablaPosiciones, {fontFamily: 'GothamBold'}]}>EMBAJADORES</Text>
                        </View>
                        <View style={{width: '30%', justifyContent: 'center', alignItems: 'center'}}>
                            <Text style={[Styles.tablaPosiciones, {fontFamily: 'GothamBold'}]}>PUNTOS</Text>
                        </View>
                    </View>
                    <ScrollView>
                        {
                            this.state.dataSource.map(( item, key ) => (
                                <View key = { key } style={[Styles.rowView, {justifyContent: 'center', padding: 10, borderBottomColor: '#eeeff1', borderBottomWidth: 1, borderTopColor: '#eeeff1', borderTopWidth: 1}]}>
                                    <View style={[Styles.rowView, {width: '20%', justifyContent: 'center', alignItems: 'center'}]}>
                                        <Text style={Styles.tablaPosiciones}>{key + 1}</Text>
                                        <Image
                                            source={{uri: global.apiUrl+'archivos/'+item.archivo}}
                                            style={{width: 30, height: 30, borderRadius: 15, marginLeft: 10}}
                                        />
                                    </View>
                                    <View style={{width: '50%', justifyContent: 'center'}}>
                                        <Text style={[Styles.tablaPosiciones, ((key + 1) < 4) ? {fontFamily: 'GothamBold'} : {fontFamily: 'GothamBook'},  {textTransform: 'uppercase'}]}>{item.nombre} {item.apellido}</Text>
                                    </View>
                                    <View style={[Styles.rowView, {width: '30%', justifyContent: 'center', alignItems: 'center'}]}>
                                        {this.renderTrophy(key + 1)}
                                        <Text style={{color: '#000', fontFamily: 'GothamBold'}}> {item.puntos} </Text>
                                        <Text style={{color: '#000', fontFamily: 'GothamBook'}}>pts</Text>
                                    </View>
                                </View>
                            ))
                        }
                    </ScrollView>
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
}