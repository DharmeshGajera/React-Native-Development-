import React from "react";
import { View, Text } from 'react-native';
import { createStackNavigator, createBottomTabNavigator, createAppContainer, createSwitchNavigator } from "react-navigation";
import ContenidoDetalleView from './ContenidoDetalleView';
import NoticiasView from './NoticiasView';
import ActividadesView from './ActividadesView';
import SocialMediaView from './SocialMediaView';
import IconAwesome from 'react-native-vector-icons/FontAwesome5';

const NoticiasCombo = createStackNavigator({
  Noticias: NoticiasView,
  ContenidoDetalle: ContenidoDetalleView,
}, {
    headerMode: 'none',
});

const ActividadesCombo = createStackNavigator({
  Actividades: ActividadesView,
  ContenidoDetalle: ContenidoDetalleView,
}, {
    headerMode: 'none',
});

const SocialCombo = createStackNavigator({
  Social: SocialMediaView,
  ContenidoDetalle: ContenidoDetalleView,
}, {
    headerMode: 'none',
});

const TabNavigator = createBottomTabNavigator({
  Noticias: NoticiasCombo,
  Social: {
    screen: SocialCombo,
    navigationOptions: ({navigation}) => ({
      title: 'Redes Sociales'
    })
  },
  Actividades: ActividadesCombo,
},
  {
    defaultNavigationOptions: ({ navigation }) => ({
      tabBarIcon: ({ tintColor }) => {
        const { routeName } = navigation.state;
        let iconName;
        if (routeName === 'Noticias') {
          iconName = 'newspaper';
        } else if (routeName === 'Actividades') {
          iconName = 'building';
        } else if (routeName === 'Social') {
          iconName = 'hashtag';
        }

        return <IconAwesome name={iconName} size={25} color={tintColor} />;
      },
    }),
    tabBarOptions: {
      activeTintColor: '#000',
      inactiveTintColor: 'gray',
    },
  });


const AppContainer = createAppContainer(TabNavigator);
export default AppContainer;