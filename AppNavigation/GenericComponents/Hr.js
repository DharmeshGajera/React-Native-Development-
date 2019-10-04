import React, { Component } from 'react';
import { View } from 'react-native';

export default class Hr extends Component {
    constructor(props) {
        super(props);
        this.color = props.color ? props.color : "#AEADB3";
        this.height = props.height ? props.height : 1;
        this.width = props.width ? props.width : "100%";
        this.extraStyles = props.extraStyles ? props.extraStyles : '';
    }

    render() {
        return (
            <View
                style={[{
                    backgroundColor: this.color,
                    height: this.height,
                    width: this.width,
                },this.extraStyles,
            ]}
        />);
    }
}