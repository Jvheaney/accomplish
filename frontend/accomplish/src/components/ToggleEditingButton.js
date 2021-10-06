import React, {Component} from 'react';
import { Text, TouchableOpacity } from 'react-native';

class ToggleEditingButton extends Component {

  render() {

    return (
      <TouchableOpacity activeOpacity={0.7} onPress={() => { this.props.toggleEditing() }} style={{height: 'auto', alignItems: 'center', marginBottom: 20, paddingTop: 2, paddingBottom: 2, paddingLeft: 10, paddingRight: 10, borderRadius: 20, backgroundColor: (this.props.isEditing)?"#A32CC4":"white", borderWidth: 3, borderColor: "#A32CC4", flexDirection: 'row'}}>
        {
        (this.props.isEditing)?
          <Text style={{fontSize: 15, fontFamily: "Bubblegum Sans", color: "white"}}>Finish Editing</Text>
        :
          <Text style={{fontSize: 15, fontFamily: "Bubblegum Sans", color:"#A32CC4"}}>Start Editing</Text>
        }
      </TouchableOpacity>
   );
 }
}

export default ToggleEditingButton;
