const ERRORS = {

    companyField:'select a company',
    departmentField: 'select a department',
    categoryField: 'select a category',
    reporterField:'select a reporter',
  //  statusesField:'',
    graphField:'choose type(s) of graph'
};


    new Vue({
        el: "#report",
        data: {
            company: '',
            department: '',
            category: '',
            reporter: '',
            statuses: '',
            graphs:['pie','bar'],
            submition: false
        },
        computed: {
            wrongCompany:function() {
                if(this.company === '') {
                    this.companyFB = ERRORS.companyField;
                    return true
                }
                return false
            },
            wrongDepartment:function()
            {  if(this.department === '') {
                this.departmentFB = ERRORS.departmentField;
                return true
            }
                return false },
            wrongCategory:function()
            {
                if(this.category === '') {
                this.categoryFB = ERRORS.categoryField;
                return true
            }
                return false },

            wrongReporter:function()
            { if(this.reporter === '')
            {
                this.reporterFB = ERRORS.reporterField;
                return true
            }
                return false }

            // wrongGraph:function()
            // {
            //     if(this.graph === '')
            // {
            //     this.graphFB = ERRORS.graphField;
            //     return true
            // }
            //     return false },

        },
        methods: {
            validateForm:function(event) {
                this.submition = true;
                if(this.wrongCompany || this.wrongDepartment || this.wrongCategory ||  this.wrongReporter)
                {
                    event.preventDefault();
                }
                else {
                    return this.submition = true;
                }
            }

        }
    });
