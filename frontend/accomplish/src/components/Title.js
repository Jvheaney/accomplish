import React, {Component} from 'react';
import { View, Text } from 'react-native';

class Title extends Component {

  render() {

    return (
      <View style={{width: '100%', height: 'auto', alignItems: "center", marginTop: 50, marginBottom: 10}}>
        <Text style={{fontSize: 50, fontFamily: "Bubblegum Sans", color: 'white', textDecoration: 'underline'}}>Today's Todos</Text>
      </View>
   );
 }
}

export default Title;
