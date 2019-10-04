import React from "react";
import { createStackNavigator, createDrawerNavigator, createAppContainer } from "react-navigation";
import CustomDrawerNavigator from "../GenericComponents/CustomDrawerNavigator";
import ContenidosDrawerView from "./ContenidosDrawerView";
import UsuariosView from "./UsuariosView";
import UsuariosDetalleView from "./UsuariosDetalleView";
import LastNewsView from "./LastNewsView";
import PerfilView from "./PerfilView";
import { Icon } from 'native-base';

const ContenidosCombo = createStackNavigator({
    ContenidosDrawer: ContenidosDrawerView,
}, {
    headerMode: 'none',
});

const UsuariosCombo = createStackNavigator({
    Usuarios: UsuariosView,
    UsuariosDetalle: UsuariosDetalleView,
}, {
    headerMode: 'none',
});

const LastNewsSolo = createStackNavigator({
    LastNews: LastNewsView,
}, {
    headerMode: 'none',
});

const PerfilSolo = createStackNavigator({
    Perfil: PerfilView,
}, {
    headerMode: 'none',
});

const DrawerNavigator = createDrawerNavigator(
  {
    LastNews: {
      navigationOptions: {
        drawerIcon: ({ tintColor }) => (
          <Icon name='home' />
        ),
        drawerLabel: "Home"
      },
      screen: LastNewsSolo
    },

    Contenidos: {
      navigationOptions: {
        drawerIcon: ({ tintColor }) => (
          <Icon name='book' />
        ),
        drawerLabel: "Contenidos"
      },
      screen: ContenidosCombo
    },

    Usuarios: {
      navigationOptions: {
        drawerIcon: ({ tintColor }) => (
          <Icon name='people' />
        ),
        drawerLabel: "Embajadores"
      },
      screen: UsuariosCombo
    },

    Perfil: {
      navigationOptions: {
        drawerIcon: ({ tintColor }) => (
          <Icon name='md-person' />
        ),
        drawerLabel: "Mi Perfil"
      },
      screen: PerfilSolo
    }
  },
  {
    contentComponent: CustomDrawerNavigator,
  }
);

const AppContainer = createAppContainer(DrawerNavigator);
export default AppContainer;