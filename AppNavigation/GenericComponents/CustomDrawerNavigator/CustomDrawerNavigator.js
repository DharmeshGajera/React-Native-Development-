import React from "react";
import { View, Image, SafeAreaView, ScrollView, ImageBackground, Text } from "react-native";
import { DrawerItems } from "react-navigation";
import Styles from '../../Assets/Css/Styles.js';

const CustomDrawerNavigator = props => (
  	<View style={{ flex: 1 }}>
	  	<View style={{height: 150}}>
	  		<ImageBackground source={require('../../Assets/Images/fondo.jpg')} style={[Styles.rowView, {width: '100%', height: '100%', alignItems:'center', justifyContent:'center', padding: 10}]}>
	  			<View style={{marginLeft: '5%', width: '30%'}}>
	                <Image
	                    source={{uri: global.apiUrl+'archivos/'+global.archivo}}
	                    style={{width: 70, height: 70, borderRadius: 37}}
	                />
	            </View>
	  			<View style={{ marginLeft: 10, marginRight: 10, width: '65%' }}>
	                <Text style={{color: '#fff', fontFamily: 'GothamBook', fontSize: 24}}>{global.nombre+' '+global.apellido}</Text>
	            </View>
	  		</ImageBackground>
	  	</View>
  		<ScrollView style={{marginTop: -5}}>
		  	<DrawerItems
		  		{...props}
		    	activeBackgroundColor={"#f0f0f0"}
		      	activeTintColor={"#000"}
		      	labelStyle={{fontFamily:'GothamLight', fontSize: 20}}
		    />
  		</ScrollView>
  	</View>
);

export default CustomDrawerNavigator;