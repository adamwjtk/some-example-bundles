let AjaxSection = React.createClass({
    getInitialState: function() {
        return {
            response: []
        }
    },

    componentDidMount: function() {
        this.rest();
    },

    rest: function() {
        $.ajax({
            url: this.props.url,
            success: function (data) {
                this.setState({response: data});
            }.bind(this)
        });
    },

    render: function () {
        if(this.state.response.status){
            return (
                <div className={'alert alert-success'}>
                    <p>{this.state.response.message} &nbsp; id: {this.state.response.body.id}</p>
                </div>
            );
        } else {
            return (
                <div className={'alert alert-danger'}>
                    <p>Błąd - spróbuj ponownie</p>
                </div>
            );
        }

    }
});

window.AjaxSection = AjaxSection;