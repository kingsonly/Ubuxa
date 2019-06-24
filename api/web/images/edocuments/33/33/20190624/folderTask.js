import React, { Component } from 'react';
import { View, Text, ScrollView, StyleSheet, FlatList, TouchableOpacity, Dimensions, ActivityIndicator, KeyboardAvoidingView, Platform} from 'react-native';
import styles from './styles';
import { Container, Icon } from 'native-base';
import { SearchBar, CheckBox, ListItem, Input} from 'react-native-elements';
import Modal from "react-native-modal";
import {connect} from 'react-redux';
import * as actions from '../../actions';
import {checkTask, addTasks} from "../../actions/api";
import { withNavigation } from 'react-navigation';
import Moment from 'moment';
import DateTimePicker from "react-native-modal-datetime-picker";
import io from "socket.io-client/dist/socket.io";
import { Header } from 'react-navigation';
import {widthPercentageToDP as wp, heightPercentageToDP as hp} from 'react-native-responsive-screen';


let ids = 0;
const DEVICE_WIDTH = Dimensions.get('window').width;
const { width, height } = Dimensions.get('window');
let today = new Date();
let todays = new Date();
let yesterday = todays.setDate(todays.getDate() - 1);
class FolderTaskScreen extends React.Component {
    constructor(props) {
        super(props);
        this.socket = io('http://127.0.0.1:4000/task')
        this.state = {
            search: '',
            data: [],
            text: '',
            filterModal: false,
            addModal: false,
            notStarted: [],
            inProgress: [],
            completed: [], 
            loading: true,
            items: [],
            checked: false,
            dateVisible: false,
            date: '22 Sep 2019',
            isLoading: false,
            notStartedCheck: false,
            inProgressCheck: false,
            completedCheck: false,
            todayCheck: false,
            yesterdayCheck: false,
            specificCheck: false,
            resetList: false,
            focused: false
        }
    }

    isEmpty(obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }
    
        return true;
    }

    componentDidMount(){
    
        let that = this;
        let { navigation } = this.props;
        let folder = navigation.getParam('folderId');
        ids = folder;
        this.socket.on('task title',  function(data){
            that.props.addTask(ids, data)
            console.log(that.props.tasks[ids])
        })
        this.setState({items: this.props.tasks[ids]})
        let temp1 = [], temp2 = [], temp3 = [];
        const {items} = this.state;
        if(!this.isEmpty(this.props.tasks[ids])){ 
            // let notStarted = this.props.tasks[ids].filter(({ status_id }) => status_id === 21);
            // let inProgress = this.props.tasks[ids].filter(({ status_id }) => status_id === 22);
            // let completed = this.props.tasks[ids].filter(({ status_id }) => status_id === 24);
            // this.setState({ notStarted: notStarted, inProgress: inProgress, completed: completed, loading: false});
            // console.log(test)
             this.props.tasks[ids].map(ele => {
                switch (ele.status_id) {
                    case 21:
                        temp1.push(ele); break;
                    case 22:
                        temp2.push(ele); break;
                    case 24:
                        temp3.push(ele); break;
                    default: break;
                }
            });
            temp1 = [...new Set(temp1)];
            temp2 = [...new Set(temp2)];
            temp3 = [...new Set(temp3)];
            this.setState({ notStarted: temp1, inProgress: temp2, completed: temp3, loading: false});
        }
   }

    static getDerivedStateFromProps(nextProps, prevState){
        if(nextProps.tasks!==prevState.items){
            console.log('before')
          return { items: nextProps.tasks};
       }
       else return null;
     }

     componentDidUpdate(prevProps, prevState) {
        let temp1 = [], temp2 = [], temp3 = [];
        if(prevProps.tasks!==this.props.tasks){
            console.log('i am here')
            if(!this.isEmpty(this.props.tasks[ids])){
                 this.props.tasks[ids].map(ele => {
                    switch (ele.status_id) {
                        case 21:
                            temp1.push(ele); break;
                        case 22:
                            temp2.push(ele); break;
                        case 24:
                            temp3.push(ele); break;
                        default: break;
                    }
                });
            }
            temp1 = [...new Set(temp1)];
            temp2 = [...new Set(temp2)];
            temp3 = [...new Set(temp3)];
            this.setState({ notStarted: temp1, inProgress: temp2, completed: temp3, loading: false, items: this.props.tasks[ids]});
        }
    }
    
    componentWillUnmount() {
        this.setState({ filterModal: false })
    }

    openFilter() {
        this.setState({ filterModal: true })
    }

    showDatePicker = () => {
        this.setState({ dateVisible: true });
    };

    hideDatePicker = () => {
        this.setState({ dateVisible: false });
    };

    handleDatePicked = date => {
        let data = this.state.items;
        this.setState({resetList: true})
        this.setState({ todayCheck: false, yesterdayCheck: false})
        let newArr = data[ids].filter(o => Moment(o.due_date).format('MMM DD YYYY')  === Moment(date).format('MMM DD YYYY'));
        let arr = this.filterManipulation(newArr);
        this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
        this.hideDatePicker();
    };

    resetList = () => {
        let data = this.state.items;
        let arr = this.filterManipulation(data[ids]);
        this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3, resetList:false});
    }

    addTaskss() {
        this.setState({ addModal: true })
    }

    filterManipulation(newArr){
        let temp1 = [], temp2 = [], temp3 = [];
        newArr.map(ele => {
            switch (ele.status_id) {
                case 21:
                    temp1.push(ele); break;
                case 22:
                    temp2.push(ele); break;
                case 24:
                    temp3.push(ele); break;
                default: break;
            }
        });
        return {temp1, temp2, temp3}
    }
    filterTask(type){
        let data = this.state.items
        if(type == 21){
            if(this.state.notStartedCheck == false){
                this.setState({notStartedCheck: true, inProgressCheck: false, completedCheck: false})
                let newArr = data[ids].filter(o => o.status_id  === type);
                let arr = this.filterManipulation(newArr);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }else{
                this.setState({notStartedCheck: false})
                let arr = this.filterManipulation(data[ids]);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }
        }else if (type == 22){
            if(this.state.inProgressCheck == false){
                this.setState({notStartedCheck: false, inProgressCheck: true, completedCheck: false})
                let newArr = data[ids].filter(o => o.status_id  === type);
                let arr = this.filterManipulation(newArr);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }else{
                this.setState({inProgressCheck: false})
                let arr = this.filterManipulation(data[ids]);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }
        }else{
            if(this.state.completedCheck == false){
                this.setState({notStartedCheck: false, inProgressCheck: false, completedCheck: true})
                let newArr = data[ids].filter(o => o.status_id  === type);
                let arr = this.filterManipulation(newArr);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }else{
                this.setState({completedCheck: false})
                let arr = this.filterManipulation(data[ids]);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }
        }
    }
    
    
    filterTaskByDate = (date, type) => {
        let data = this.state.items
        if(type == 'today'){
            if(this.state.todayCheck == false){
                this.setState({todayCheck: true, yesterdayCheck: false})
                let newArr = data[ids].filter(o => Moment(o.due_date).format('MMM DD YYYY')  === Moment(date).format('MMM DD YYYY'));
                let arr = this.filterManipulation(newArr);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }else{
                this.setState({todayCheck: false})
                let arr = this.filterManipulation(data[ids]);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }
        }else if(type == 'yesterday'){
            if(this.state.yesterdayCheck == false){
                this.setState({yesterdayCheck: true, todayCheck: false})
                let newArr = data[ids].filter(o => Moment(o.due_date).format('MMM DD YYYY')  === Moment(date).format('MMM DD YYYY'));
                let arr = this.filterManipulation(newArr);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }else{
                this.setState({yesterdayCheck: false})
                let arr = this.filterManipulation(data[ids]);
                this.setState({ notStarted: arr.temp1, inProgress: arr.temp2, completed: arr.temp3});
            }
        }
    }

    render() {
        const { loading, notStarted, inProgress, completed} = this.state;
        const { folderTitle } = this.props;
        if(!loading) {
        return <KeyboardAvoidingView
                behavior="padding"
                keyboardVerticalOffset = {Header.HEIGHT + 70}
                style={{ flex: 1 }}>
            <Container>
                <Modal
                    isVisible={this.state.filterModal}
                    style={{ backgroundColor: '#1275bcef', borderRadius: 10, marginHorizontal: 30, marginVertical: (height - 400) / 2 }}
                    deviceHeight={height}
                    backdropColor='transparent'
                    onBackdropPress={() => this.setState({ filterModal: false })}
                >
                    <View style={{ marginTop: 22, height: 400, paddingVertical: 15, paddingHorizontal: 20 }}>
                        <View>
                            <Text style={{ color: '#fff', textAlign: 'center', fontSize: 18, }}>Filters</Text>
                            <Icon style={{ color: 'white', position: 'absolute', top: 0, right: 0 }} name='clear' type='MaterialIcons' onPress={() => this.setState({ filterModal: false })} />
                            <View style={{ marginBottom: 10 }}>
                                <Text style={{ fontWeight: '700', marginBottom: 10, color: '#fff' }}>By time</Text>
                                <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Text style={{ color: '#fff' }}>Today</Text>
                                    <CheckBox
                                        containerStyle={{ borderWidth: 0, paddingLeft: 0, backgroundColor: 'transparent', marginLeft: 0, marginRight: 0, padding: 0 }}
                                        textStyle={{ fontWeight: 'normal', color: '#fff' }}
                                        iconRight={true}
                                        right
                                        checkedColor='#fff'
                                        uncheckedColor='#fff'
                                        onPress={() => this.filterTaskByDate(today, 'today')}
                                        checked={this.state.todayCheck}
                                    />
                                </View>

                                <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Text style={{ color: '#fff' }}>Yesterday</Text>
                                    <CheckBox
                                        containerStyle={{ borderWidth: 0, paddingLeft: 0, backgroundColor: 'transparent', marginLeft: 0, marginRight: 0, padding: 0 }}
                                        textStyle={{ fontWeight: 'normal', color: '#fff' }}
                                        iconRight={true}
                                        right
                                        checkedColor='#fff'
                                        uncheckedColor='#fff'
                                        onPress={() => this.filterTaskByDate(yesterday, 'yesterday')}
                                        checked={this.state.yesterdayCheck}
                                    />
                                </View>
                                <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Text style={{ color: '#fff' }}>Specific date</Text>
                                    <TouchableOpacity onPress={this.showDatePicker} style={{ alignItems: 'center', flexDirection: 'row', flex: 1, justifyContent: 'flex-end' }}>
                                     {this.state.resetList !== false ?
                                        <Icon style={{ color: 'white', position: 'absolute', top: 1, right: 40, fontSize: 22}} name='times-circle' type='FontAwesome' onPress={() => this.resetList()} />
                                        : null
                                     }
                                    <Icon style={{ color: '#fff', fontSize: 24, marginRight: 3 }} name='calendar' type='MaterialCommunityIcons' />
                                    </TouchableOpacity>
                                    <DateTimePicker
                                        isVisible={this.state.dateVisible}
                                        onConfirm={this.handleDatePicked}
                                        onCancel={this.hideDatePicker}
                                        mode='date'
                                    />
                                </View>

                            </View>
                            <View style={{ marginBottom: 10, marginTop: 20 }}>
                                <Text style={{ fontWeight: '700', marginBottom: 10, color: '#fff' }}>By Progress</Text>
                                <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Text style={{ color: '#fff' }}>Not started</Text>

                                    <CheckBox
                                        containerStyle={{ borderWidth: 0, paddingLeft: 0, backgroundColor: 'transparent', marginLeft: 0, marginRight: 0, padding: 0 }}
                                        textStyle={{ fontWeight: 'normal', color: '#fff' }}
                                        iconRight={true}
                                        right
                                        checkedColor='#fff'
                                        uncheckedColor='#fff'
                                        onPress={() => this.filterTask(21)}
                                        checked={this.state.notStartedCheck}
                                    />
                                </View>

                                <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Text style={{ color: '#fff' }}>In Progress</Text>

                                    <CheckBox
                                        containerStyle={{ borderWidth: 0, paddingLeft: 0, backgroundColor: 'transparent', marginLeft: 0, marginRight: 0, padding: 0 }}
                                        textStyle={{ fontWeight: 'normal', color: '#fff' }}
                                        iconRight={true}
                                        right
                                        checkedColor='#fff'
                                        uncheckedColor='#fff'
                                        onPress={() => this.filterTask(22)}
                                        checked={this.state.inProgressCheck}
                                    />
                                </View>

                                <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Text style={{ color: '#fff' }}>Completed</Text>

                                    <CheckBox
                                        containerStyle={{ borderWidth: 0, paddingLeft: 0, backgroundColor: 'transparent', marginLeft: 0, marginRight: 0, padding: 0 }}
                                        textStyle={{ fontWeight: 'normal', color: '#fff' }}
                                        iconRight={true}
                                        right
                                        checkedColor='#fff'
                                        uncheckedColor='#fff'
                                        onPress={() => this.filterTask(24)}
                                        checked={this.state.completedCheck}
                                    />
                                </View>
                            </View>
                        </View>
                    </View>
                </Modal>
                <Modal
                    isVisible={this.state.addModal}
                    style={{ backgroundColor: '#ffffffc3', width: width, height: height, margin: 0 }}
                    animationIn='fadeIn'
                    animationInTiming={10}
                    animationOut="fadeOut"
                    animationOutTiming={10}
                    deviceHeight={height}
                    backdropColor='transparent'

                    coverScreen
                    onBackdropPress={() => this.setState({ addModal: false, focused: false})}
                >
                    <View style={!this.state.focused || Platform.OS !== "ios" ? {position:'absolute', bottom:0 } : {position:'absolute', bottom:hp('38%') }}>
                        <Input
                            placeholder={'Create a new task'}
                            containerStyle={{ margin:10, padding: 10, borderWidth: 1, borderColor: '#EBEBEE', flex: 1, borderRadius: 5, justifyContent:'flex-end', alignItems:'flex-end', width:width-20, backgroundColor:'#fff' }}
                            underlineColorAndroid='transparent'
                            rightIconContainerStyle={{ backgroundColor: '#EBEBEE', borderRadius: 3, paddingHorizontal: 10 }}
                            onChangeText={(text) => this.setState({text})}
                            onFocus={() => this.setState({focused: true})}
                            onBlur={() => this.setState({focused: false})}
                            rightIcon={() =>
                                this.state.isLoading == false ?
                                <Icon name='add' color='#1275bc' onPress={()=>this.addTask(this.state.text)}/>
                                : <ActivityIndicator/>
                            }
                            inputContainerStyle={{ borderBottomWidth: 0, paddingLeft: 10, }}
                            placeholderTextColor='#2E2E39'
                        />
                        
                    </View>
                </Modal>
                <View style={styles.subFolderLabelContainer}>
                    <View style={styles.horizontalLineStyle} />
                    <View style={styles.subFolderLabel}>
                        <Text style={styles.subFolderText} numberOfLines={1}>{this.props.folderTitle}</Text>
                    </View>
                    <View style={styles.horizontalLineStyle} />
                </View>
                <View style={{ flexDirection: 'row', padding: 10, alignItems: 'center', justifyContent: 'space-between', marginBottom: 20 }}>
                    <SearchBar
                        placeholder='Search for task'
                        round
                        onChangeText={text => this.searchFilterFunction(text) }
                        value={this.state.search}
                        onClear={this.resetTaskSearch()}
                        containerStyle={{ backgroundColor: 'transparent', width: width * 0.7, marginRight: 10, borderBottomWidth: 0, borderTopWidth: 0, padding: 0, borderColor: 'transparent' }}
                        inputContainerStyle={{ backgroundColor: 'transparent', borderWidth: 1, borderBottomWidth: 1, borderColor: '#939393', height: 30, borderRadius: 5 }}
                        inputStyle={{ fontSize: 12 }}
                        autoCorrect={false}
                    />
                    <View style={{ flexDirection: 'row', alignItems: 'center', }}>
                        <Text style={{ marginRight: 10 }}>Filter</Text>
                        <Icon name='filter-list' type='MaterialIcons' style={{ color: '#1275bc' }} onPress={() => this.openFilter()} />
                    </View>
                </View>
                <ScrollView style={{ paddingHorizontal: 10 }}>
                    <View style={{ marginBottom: 10 }}>
                        <Text style={{ fontWeight: '700', marginBottom: 10 }}>Not Started</Text>
                        {notStarted.length != 0 ? (
                        <FlatList
                            data={this.state.notStarted}
                            extraData={this.state}
                            keyExtractor={(item, index) => index.toString()}
                            ItemSeparatorComponent={this.renderSeparator}
                            renderItem={({ item: rowdata }) => (
                                <View style={{ flexDirection: 'row', alignItems: 'center', }}>
                                    <CheckBox
                                        containerStyle={{ borderWidth: 0, paddingLeft: 0 }}
                                        textStyle={{ fontWeight: 'normal' }}
                                        onPress={() => this.updateTask(rowdata.id, rowdata.status_id)}
                                    />
                                    <TouchableOpacity style={{ justifyContent: 'space-between', flexDirection: 'row', alignItems: 'center', flex: 1 }} onPress={() => { this.props.navigation.push('TaskDetail', {taskId: rowdata.id}) }}>
                                        <Text style={{ color: '#555', maxWidth: '60%'}}  numberOfLines={1}>{rowdata.title}</Text>
                                        { rowdata.due_date !== null ? 
                                        <Text style={{ color: '#5557', fontSize: 12 }}>{Moment(rowdata.due_date).format('MMM DD, YYYY')}</Text>
                                        : <Text style={{ color: '#5557', fontSize: 12 }}>{rowdata.due_date}</Text>} 
                                    </TouchableOpacity>
                                </View>
                            )}
                        />) : <Text style={{ marginBottom: 10, fontStyle: "italic", fontSize: 14 , color: '#c6c4c4'}}>No task here. Press the plus button to create a task</Text>}
                    </View>
                    <View style={{ marginBottom: 10 }}>
                        <Text style={{ fontWeight: '700', marginBottom: 10 }}>In Progress</Text>
                        {inProgress.length != 0 ? (
                        <FlatList
                            data={this.state.inProgress}
                            extraData={this.state}
                            keyExtractor={(item, index) => index.toString()}
                            ItemSeparatorComponent={this.renderSeparator}
                            renderItem={({ item: rowdata }) => (
                                <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <CheckBox
                                        containerStyle={{ borderWidth: 0, paddingLeft: 0 }}
                                        textStyle={{ fontWeight: 'normal' }}
                                        onPress={() => this.updateTask(rowdata.id, rowdata.status_id)}
                                        checked={this.state.checked}
                                    />
                                    <TouchableOpacity style={{ justifyContent: 'space-between', flexDirection: 'row', alignItems: 'center', flex: 1 }} onPress={() => { this.props.navigation.push('TaskDetail', {taskId: rowdata.id}) }}>
                                        <Text style={{ color: '#555', }}>{rowdata.title}</Text>
                                        { rowdata.due_date !== null ? 
                                        <Text style={{ color: '#5557', fontSize: 12 }}>{Moment(rowdata.due_date).format('MMM DD, YYYY')}</Text>
                                        : <Text style={{ color: '#5557', fontSize: 12 }}>{rowdata.due_date}</Text>}
                                    </TouchableOpacity>
                                </View>
                            )}
                        />) : <Text style={{ marginBottom: 10, fontStyle: "italic", fontSize: 14 , color: '#c6c4c4'}}>No task in progress</Text>}
                    </View>
                    <View style={{ marginBottom: 10 }}>
                        <Text style={{ fontWeight: '700', marginBottom: 10 }}>Completed</Text>
                        {completed.length != 0 ? (
                        <FlatList
                            data={this.state.completed}
                            extraData={this.state}
                            keyExtractor={(item, index) => index.toString()}
                            ItemSeparatorComponent={this.renderSeparator}
                            renderItem={({ item: rowdata }) => (
                                <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <CheckBox
                                        containerStyle={{ borderWidth: 0, paddingLeft: 0 }}
                                        textStyle={{}}
                                        checked={true}
                                        checkedIcon='check'
                                        checkedColor='#83D703'
                                        onPress={() => this.updateTask(rowdata.id)}
                                    />
                                    <TouchableOpacity style={{ justifyContent: 'space-between', flexDirection: 'row', alignItems: 'center', flex: 1 }} onPress={() => { this.props.navigation.push('TaskDetail', {taskId: rowdata.id}) }}>
                                        <Text style={{ color: '#555', fontWeight: 'normal', textDecorationLine: 'line-through'}}>{rowdata.title}</Text>
                                        { rowdata.due_date !== null ? 
                                        <Text style={{ color: '#5557', fontSize: 12, fontWeight: 'normal', textDecorationLine: 'line-through' }}>{Moment(rowdata.due_date).format('MMM DD, YYYY')}</Text>
                                        : <Text style={{ color: '#5557', fontSize: 12, fontWeight: 'normal', textDecorationLine: 'line-through' }}>{rowdata.due_date}</Text>}
                                    </TouchableOpacity>
                                </View>
                            )}
                        />) : <Text style={{ marginBottom: 10, fontStyle: "italic", fontSize: 14 , color: '#c6c4c4'}}>No completed task</Text>}
                    </View>
                </ScrollView>

                <View style={styles.horizontalFullLineStyle} />
                <View style={styles.addFolderContainer}>
                    <TouchableOpacity style={styles.addButton} onPress={() => { this.addTaskss() }}>
                        <Icon name='add' type='MaterialIcons' style={{ color: 'white', fontSize: 25}} />
                    </TouchableOpacity>
                    <Text style={{ color: '#5557', marginLeft: 10 }}>Add a new task</Text>
                </View>
            </Container>
            </KeyboardAvoidingView>
        }else{
            return <View
                style={{
                flex: 1,
                padding: 20,
                alignContent :'center',
                justifyContent :'center',
                }}>
    
                <ActivityIndicator size="large" color="#1275bc" />
            </View>
        }
    }
   

    searchFilterFunction = text => {    
        const newData = this.state.items[ids].filter(item => {      
          const itemData = `${item.title.toUpperCase()}`;
           const textData = text.toUpperCase();
            
           return itemData.indexOf(textData) > -1;    
        }); 
        newData.map(x => {
            if(x.status_id == 21){
                let newDatum = newData.filter(obj => obj.status_id == 21)
                this.setState({ notStarted: newDatum, search: text});
            }else if (x.status_id == 22){
                let newDatum = newData.filter(obj => obj.status_id == 22)
                this.setState({ inProgress: newDatum, search: text});
            }else if(x.status_id == 24){
                let newDatum = newData.filter(obj => obj.status_id == 24)
                this.setState({ completed: newDatum, search: text});
            }else{
                this.setState({ search: text});  
            }    
        });
          
        this.setState({ search: text});    
    };

    resetTaskSearch () {
        //this.setState({notStarted: temp1, inProgress: temp2, completed: temp3})
        //alert(1234)
    }


    async addTask(text){
        this.setState({focused: false})
        if(text.trim() !== ''){
            let that = this;
            this.setState({isLoading: true})
            
            await addTasks(this.props.folderId, text, that, this.props.accessToken).then(function(data){    
                that.setState({text: ''})
                that.socket.emit('task title', data.data);
            })
        }
    }
    
    async updateTask(taskId, status){
        let that = this;
        let arr1 = this.state.notStarted;
        let arr2 = this.state.inProgress;
        let arr3 = this.state.completed;
        await checkTask(taskId, this.props.accessToken).then(function(data) {
            if(data.data.status_id == 24 && status == 21){
                arr3.push(data.data);
                arr1 = arr1.filter(obj => obj.id !== taskId)
                that.setState({notStarted: arr1, completed: arr3})
            }else if(data.data.status_id == 24 && status == 22){
                arr3.push(data.data);
                arr2 = arr2.filter(obj => obj.id !== taskId)
                that.setState({inProgress: arr2, completed: arr3})
            }else{
                arr1.push(data.data);
                arr3 = arr3.filter(obj => obj.id !== taskId)
                that.setState({notStarted: arr1, completed: arr3})
            }
        })
        let allTemps = arr1.concat(arr2, arr3);
        this.props.folderTasks({[ids]: allTemps})
        this.setState({items: this.props.tasks[ids]})
    }

}
const mapStateToProps = state => {
    return {tasks: state.tasks.tasks, loading: state.tasks.loading, folderId: state.folderId, accessToken: state.accessToken}
}

export default connect(mapStateToProps, actions)(withNavigation(FolderTaskScreen));

