import React from "react";
import { createStackNavigator, createAppContainer } from "react-navigation";
import LoginView from "./Views/LoginView";
import OlvidoClaveView from "./Views/OlvidoClaveView";
import MainAppView from "./Views/MainAppView";

const LoginStackNavigator = createStackNavigator({
  Login: LoginView,
  OlvidoClave: OlvidoClaveView,
  MainApp: MainAppView,
}, {
  headerMode: 'none',
});

const AppContainer = createAppContainer(LoginStackNavigator);
export default AppContainer;