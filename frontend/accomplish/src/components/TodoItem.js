import React, {Component} from 'react';
import { View, Text, TouchableOpacity, TextInput } from 'react-native';

class TodoItem extends Component {

  state = {
    taskName: ""
  }

  _handleTaskName = (input) => {
    this.setState({
      taskName: input
    })
  }

  render() {

    return (
      <TouchableOpacity activeOpacity={0.7} onPress={() => { if(!this.props.editingTask && !this.props.isEditing){this.props.toggleTask()} }} style={{height: 'auto', alignItems: 'center', marginTop: 10, marginBottom: 10, flexDirection: 'row'}}>
        <View style={{height: 30, width: 30, borderWidth: 5, borderColor: (this.props.checked || this.props.editingTask)?'rgba(0,0,0,0.3)':"black", borderRadius: 8, justifyContent: "center", alignItems: "center"}}>
          {(this.props.checked)?
            <Text style={{fontSize: 40, fontFamily: "Bubblegum Sans", color: 'rgba(255,0,0,0.6)'}}>X</Text>
            :
            <View></View>
          }
        </View>
        {
        (this.props.editingTask)?
            <TextInput
              value={this.state.taskName}
              numberOfLines={1}
              maxLength={64}
              placeholder={"Walk Max"}
              placeholderTextColor={"rgba(255,255,255,0.4)"}
              style={{
                borderBottomWidth: 1,
                borderColor: "rgba(255,255,255,0.4)",
                fontFamily: "Bubblegum Sans",
                fontSize: 30,
                padding: 5,
                color: "white",
                marginTop: 5,
                marginLeft: 20
              }}
              onChangeText={(input) => this._handleTaskName(input)}
              />
          :
          <Text style={{marginLeft: 20, fontSize: 30, fontFamily: "Bubblegum Sans", color: (this.props.checked)?'rgba(0,0,0,0.3)':"black"}}>{this.props.taskName}</Text>
        }
        {
          (this.props.editingTask)?
          <TouchableOpacity activeOpacity={0.7} onPress={() => { this.props.saveTask(this.state.taskName) }} style={{marginLeft: 30, height: 30, width: 30, backgroundColor: 'green', borderRadius: 30, justifyContent: 'center', alignItems: 'center'}}>
            <Text style={{fontSize: 30, fontFamily: "Bubblegum Sans", color: 'white'}}>&#10003;</Text>
          </TouchableOpacity>
          :
          (this.props.isEditing)?
          <TouchableOpacity activeOpacity={0.7} onPress={() => { this.props.removeTask() }} style={{marginLeft: 30, height: 30, width: 30, backgroundColor: 'red', borderRadius: 30, justifyContent: 'center', alignItems: 'center'}}>
            <View style={{width: 20, height: 5, backgroundColor: "white"}}>
            </View>
          </TouchableOpacity>
          :
          <View></View>
        }
      </TouchableOpacity>
   );
 }
}

export default TodoItem;
