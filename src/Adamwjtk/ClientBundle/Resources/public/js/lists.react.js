let ListSection = React.createClass({
    getInitialState: function() {
        return {
            products: []
        }
    },

    componentDidMount: function() {
        this.loadListFromServer();
        setInterval(this.loadListFromServer, 90000);
    },

    loadListFromServer: function() {
        let elink = this.props.eurl;
        let rlink = this.props.rurl;
        $.ajax({
            url: this.props.url,
            success: function (data) {
                this.setState({products: data.body.products,edit: elink, del: rlink});
            }.bind(this)
        });
    },

    render: function() {
        return (
            <div>
                <table>
                    <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="30%">Nazwa</th>
                        <th width="30%">Ilość</th>
                        <th>&nbsp; </th>
                        <th>&nbsp; </th>
                    </tr>
                    </thead>
                </table>
                <List products={this.state.products} elink={this.state.edit} rlink={this.state.del} />
            </div>

        );
    }
});

let List = React.createClass({
    render: function() {
        let editlink = this.props.elink;
        let deletelink = this.props.rlink;
        let nodes = this.props.products.map(function(note) {
            return (
                <ListBox name={note.name} amount={note.amount} key={note.id} elink={editlink} rlink={deletelink}>{note.id}</ListBox>
            );
        });

        return (
            <section>{nodes}</section>


        );
    }
});

let ListBox = React.createClass({
    render: function() {
        let updateurl = this.props.elink.slice(0,-1)+''+this.props.children;
        let removeurl = this.props.rlink.slice(0,-1)+''+this.props.children;
        return (
            <table>
                <tbody>
                <tr>
                    <td width="10%">{this.props.children}</td>
                    <td width="30%">{this.props.name}</td>
                    <td width="30%">{this.props.amount}</td>
                    <td><EditIcon  link={updateurl}/></td>
                    <td><TrashIcon link={removeurl}/></td>
                </tr>
                </tbody>
            </table>

        );
    }
});

let EditIcon = React.createClass({
    render: function(){
        let href = this.props.link;
        return (
            <a href={href} className={"btn btn-info btn-lg"}> <span className={"glyphicon glyphicon-pencil"}></span> </a>

        );
}});

let TrashIcon = React.createClass({
    render: function(){
        let href = this.props.link;
        return (
            <a href={href} className={"btn btn-danger btn-lg"}> <span className={"glyphicon glyphicon-trash"}></span> </a>

        );
    }});


window.ListSection = ListSection;
